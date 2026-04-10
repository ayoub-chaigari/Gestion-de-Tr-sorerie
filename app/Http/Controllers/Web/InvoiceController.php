<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Contact;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:invoices,view')->only(['index', 'show']);
        $this->middleware('permission:invoices,create')->only(['create', 'store', 'recordPayment']);
        $this->middleware('permission:invoices,edit')->only(['edit', 'update']);
        $this->middleware('permission:invoices,delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Invoice::with('supplier');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                      $supplierQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'overdue') {
                $query->where('status', '!=', 'paid')->whereDate('due_date', '<', now()->toDateString());
            } elseif ($status === 'at_risk') {
                $query->where('status', '!=', 'paid')
                      ->whereDate('due_date', '>=', now()->toDateString())
                      ->whereDate('due_date', '<=', now()->addDays(7)->toDateString());
            } else {
                $query->where('status', $status);
            }
        }

        $invoices = $query->orderBy('due_date', 'asc')->paginate(15)->appends($request->all());
        
        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['supplier', 'payments' => function($q) {
            $q->orderBy('payment_date', 'desc');
        }, 'payments.payable']);
        
        return view('invoices.show', compact('invoice'));
    }

    public function create()
    {
        $suppliers = Contact::where('type', 'supplier')->get();
        return view('invoices.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric|min:0',
            'invoice_date' => 'required|date',
            'delay_days' => 'required|integer|min:0',
            'reference' => 'nullable|string'
        ]);

        $data['due_date'] = date('Y-m-d', strtotime($data['invoice_date'] . ' + ' . $data['delay_days'] . ' days'));
        $data['status'] = 'pending';
        
        Invoice::create($data);
        return redirect()->route('invoices.index')->with('success', 'Facture enregistrée.');
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'payment_amount' => 'required|numeric|min:0.01|max:' . $invoice->remaining_amount,
        ]);

        $invoice->increment('paid_amount', $data['payment_amount']);
        
        if ($invoice->paid_amount >= $invoice->amount) {
            $invoice->update(['status' => 'paid']);
        }

        return redirect()->back()->with('success', 'Paiement enregistré.');
    }
}
