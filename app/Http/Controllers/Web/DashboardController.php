<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingCheque;
use App\Models\OutgoingCheque;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Platform KPIs for SuperAdmin
        $platformStats = null;
        if (auth()->user()->role === 'SUPER_ADMIN') {
            $platformStats = [
                'total_companies' => \App\Models\Company::count(),
                'total_users' => \App\Models\User::count(),
                'global_volume' => IncomingCheque::withoutGlobalScopes()->sum('amount'),
            ];
        }

        // Company Totals (TenantScope applied automatically by traits)
        // Recettes are strictly validated payments
        $encaissements = IncomingCheque::whereIn('status', ['paid', 'endorsed'])->sum('amount');
        
        // En Cours are cheques deposited but not yet cleared
        $enCours = IncomingCheque::where('status', 'deposited')->sum('amount');
        
        // Décaissements includes all unified payments (Cash, Virement, Endorsements, Issued Cheques)
        $decaissements = \App\Models\InvoicePayment::sum('amount') + 
                         OutgoingCheque::where('status', 'paid')->whereNull('invoice_id')->sum('amount');
                         
        $soldeNet = $encaissements - $decaissements;

        // Alerts
        $overdueInvoices = Invoice::with('supplier')
                            ->where('status', '!=', 'paid')
                            ->whereDate('due_date', '<=', now()->toDateString())
                            ->get();

        $atRiskInvoices = Invoice::with('supplier')
                            ->where('status', '!=', 'paid')
                            ->whereDate('due_date', '>', now()->toDateString())
                            ->whereDate('due_date', '<=', now()->addDays(7)->toDateString())
                            ->get();

        $unpaidCheques = IncomingCheque::with('contact')->where('status', 'unpaid')->get();

        // Chart Data: Last 6 months evolution
        $chartData = [];
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();

        // 1. Calculate historical baseline balance before the 6-month window starts
        $histIncoming = IncomingCheque::whereIn('status', ['paid', 'deposited', 'endorsed'])
                                ->where('due_date', '<', $sixMonthsAgo->toDateString())
                                ->sum('amount');
                                
        $histOutgoing = \App\Models\InvoicePayment::where('payment_date', '<', $sixMonthsAgo->toDateString())
                                ->sum('amount') +
                        OutgoingCheque::where('status', 'paid')
                                ->whereNull('invoice_id')
                                ->where('due_date', '<', $sixMonthsAgo->toDateString())
                                ->sum('amount');

        $cumulativeBalance = $histIncoming - $histOutgoing;

        // 2. Monthly breakdown
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->translatedFormat('M y');
            
            $monthlyIncoming = IncomingCheque::whereYear('due_date', $month->year)
                                ->whereMonth('due_date', $month->month)
                                ->whereIn('status', ['paid', 'deposited', 'endorsed'])
                                ->sum('amount');
                                
            $monthlyOutgoing = \App\Models\InvoicePayment::whereYear('payment_date', $month->year)
                                ->whereMonth('payment_date', $month->month)
                                ->sum('amount') +
                               OutgoingCheque::whereYear('due_date', $month->year)
                                ->whereMonth('due_date', $month->month)
                                ->where('status', 'paid')
                                ->whereNull('invoice_id')
                                ->sum('amount');

            $netMonthly = $monthlyIncoming - $monthlyOutgoing;
            $cumulativeBalance += $netMonthly;

            $chartData[] = [
                'month'    => $monthName,
                'incoming' => $monthlyIncoming,
                'outgoing' => $monthlyOutgoing,
                'net'      => $netMonthly,
                'balance'  => $cumulativeBalance
            ];
        }

        // 3. Recent Transactions History
        $transactions = collect();

        // Incoming (Entrées)
        $incomings = IncomingCheque::with('contact')->whereIn('status', ['paid', 'deposited', 'endorsed'])
            ->orderBy('updated_at', 'desc')->get();
        foreach ($incomings as $inc) {
            $typeLabel = $inc->type == 'effect' ? __('Effet') : __('Chèque');
            $transactions->push((object)[
                'type' => 'in',
                'id' => $inc->id,
                'date' => $inc->due_date,
                'time' => $inc->updated_at->format('H:i A'),
                'timestamp' => $inc->updated_at->timestamp ?? 0,
                'amount' => $inc->amount,
                'status' => $inc->status,
                'description' => __('Encaissement :type - :name', ['type' => $typeLabel, 'name' => ($inc->contact->name ?? __('Client'))]),
                'link' => route('cheques.index', ['search' => $inc->cheque_number])
            ]);
        }

        // Outgoing (Dépenses - Invoices)
        $invoicePayments = \App\Models\InvoicePayment::with('invoice.supplier')->orderBy('created_at', 'desc')->get();
        foreach ($invoicePayments as $pay) {
            $transactions->push((object)[
                'type' => 'out',
                'id' => $pay->id,
                'date' => $pay->payment_date,
                'time' => $pay->created_at->format('H:i A'),
                'timestamp' => $pay->created_at->timestamp ?? 0,
                'amount' => $pay->amount,
                'status' => 'paid',
                'description' => __('Paiement Facture - :name', ['name' => ($pay->invoice->supplier->name ?? __('Supplier'))]),
                'link' => route('invoices.show', $pay->invoice_id)
            ]);
        }

        // Outgoing (Dépenses - Direct)
        $outgoingCheques = OutgoingCheque::where('status', 'paid')->whereNull('invoice_id')->orderBy('updated_at', 'desc')->get();
        foreach ($outgoingCheques as $out) {
            $transactions->push((object)[
                'type' => 'out',
                'id' => $out->id,
                'date' => $out->due_date,
                'time' => $out->updated_at->format('H:i A'),
                'timestamp' => $out->updated_at->timestamp ?? 0,
                'amount' => $out->amount,
                'status' => 'paid',
                'description' => __('Débit Direct - Chèque :number', ['number' => $out->cheque_number]),
                'link' => route('outgoing-cheques.index', ['search' => $out->cheque_number])
            ]);
        }

        // All transactions for PDF (sorted, no limit)
        $allTransactions = $transactions->sortByDesc('timestamp')->values()->map(function($tx) {
            return (object) [
                'description' => $tx->description,
                'date'        => \Carbon\Carbon::parse($tx->date)->format('d/m/Y'),
                'time'        => \Carbon\Carbon::createFromTimestamp($tx->timestamp)->format('h:i A'),
                'timestamp'   => $tx->timestamp,
                'type'        => $tx->type,
                'amount'      => $tx->amount,
                'status'      => $tx->status,
                'link'        => $tx->link,
            ];
        });

        // Recent 10 for live ledger display
        $recentTransactions = $allTransactions->take(10)->values();

        // Weekly Chart Data: Last 8 weeks
        $weeklyChartData = [];
        for ($i = 7; $i >= 0; $i--) {
            $weekStart = now()->startOfWeek()->subWeeks($i);
            $weekEnd   = (clone $weekStart)->endOfWeek();
            $label     = $weekStart->format('d/m');

            $weeklyIncoming = IncomingCheque::whereIn('status', ['paid', 'deposited', 'endorsed'])
                                ->whereBetween('due_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
                                ->sum('amount');

            $weeklyOutgoing = \App\Models\InvoicePayment::whereBetween('payment_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
                                ->sum('amount') +
                              OutgoingCheque::where('status', 'paid')->whereNull('invoice_id')
                                ->whereBetween('due_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
                                ->sum('amount');

            $weeklyChartData[] = [
                'week'     => $label,
                'incoming' => $weeklyIncoming,
                'outgoing' => $weeklyOutgoing,
            ];
        }

        return view('dashboard', compact('encaissements', 'enCours', 'decaissements', 'soldeNet', 'overdueInvoices', 'atRiskInvoices', 'unpaidCheques', 'platformStats', 'chartData', 'weeklyChartData', 'recentTransactions', 'allTransactions'));
    }
}
