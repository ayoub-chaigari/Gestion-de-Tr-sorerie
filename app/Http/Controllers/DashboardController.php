<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\IncomingCheque;
use App\Models\OutgoingCheque;
use App\Models\Invoice;

class DashboardController extends Controller {
    public function summary() {
        $incoming = IncomingCheque::sum('amount');
        $outgoing = OutgoingCheque::sum('amount');
        $invoices = Invoice::sum('amount');
        return response()->json(compact('incoming', 'outgoing', 'invoices'));
    }
    public function alerts() {
        $overdueInvoices = Invoice::where('status', 'overdue')->get();
        $unpaidCheques = IncomingCheque::where('status', 'unpaid')->get();
        return response()->json([
            'overdue_invoices' => $overdueInvoices,
            'unpaid_cheques' => $unpaidCheques
        ]);
    }
}