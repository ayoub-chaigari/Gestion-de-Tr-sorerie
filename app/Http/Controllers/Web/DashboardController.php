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
            ->orderBy('updated_at', 'desc')->take(15)->get();
        foreach ($incomings as $inc) {
            $transactions->push((object)[
                'type' => 'in',
                'date' => $inc->due_date,
                'timestamp' => $inc->updated_at->timestamp ?? 0,
                'amount' => $inc->amount,
                'status' => $inc->status,
                'description' => "Encaissement " . ($inc->type == 'effect' ? 'Effet' : 'Chèque') . " - " . ($inc->contact->name ?? 'Client')
            ]);
        }

        // Outgoing (Dépenses - Invoices)
        $invoicePayments = \App\Models\InvoicePayment::with('invoice.supplier')->orderBy('created_at', 'desc')->take(15)->get();
        foreach ($invoicePayments as $pay) {
            $transactions->push((object)[
                'type' => 'out',
                'date' => $pay->payment_date,
                'timestamp' => $pay->created_at->timestamp ?? 0,
                'amount' => $pay->amount,
                'status' => 'paid',
                'description' => "Paiement Facture - " . ($pay->invoice->supplier->name ?? 'Fournisseur')
            ]);
        }

        // Outgoing (Dépenses - Direct)
        $outgoingCheques = OutgoingCheque::where('status', 'paid')->whereNull('invoice_id')->orderBy('updated_at', 'desc')->take(15)->get();
        foreach ($outgoingCheques as $out) {
            $transactions->push((object)[
                'type' => 'out',
                'date' => $out->due_date,
                'timestamp' => $out->updated_at->timestamp ?? 0,
                'amount' => $out->amount,
                'status' => 'paid',
                'description' => "Débit Direct - Chèque " . $out->cheque_number
            ]);
        }

        $recentTransactions = $transactions->sortByDesc('timestamp')->take(10)->values();

        return view('dashboard', compact('encaissements', 'enCours', 'decaissements', 'soldeNet', 'overdueInvoices', 'atRiskInvoices', 'unpaidCheques', 'platformStats', 'chartData', 'recentTransactions'));
    }
}
