<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingCheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusAlertNotification;

class ChequeController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingCheque::with(['contact', 'bankAccount', 'invoice', 'payments.invoice']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cheque_number', 'like', "%{$search}%")
                  ->orWhere('bank_name', 'like', "%{$search}%")
                  ->orWhereHas('contact', function ($contactQuery) use ($search) {
                      $contactQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cheques = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->all());
        
        $suppliers = \App\Models\Contact::where('type', 'supplier')->get();
        $invoices  = \App\Models\Invoice::whereIn('status', ['pending', 'partial', 'overdue'])->get();
        
        return view('cheques.index', compact('cheques', 'suppliers', 'invoices'));
    }

    public function create()
    {
        $clients = \App\Models\Contact::where('type', 'client')->get();
        $banks   = \App\Http\Controllers\Web\TreasuryController::$banks;
        return view('cheques.create', compact('clients', 'banks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id'   => 'required|exists:contacts,id',
            'amount'       => 'required|numeric|min:0.01',
            'cheque_number'=> 'required|string|max:255',
            'bank_name'    => 'required|string|max:255',
            'due_date'     => 'required|date',
            'is_effect'    => 'sometimes|boolean',
        ]);
        $data['is_effect'] = $request->has('is_effect');
        $data['status']    = 'pending';
        IncomingCheque::create($data);
        return redirect()->route('cheques.index')->with('success', 'Chèque recette enregistré avec succès.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,deposited,paid,unpaid,endorsed']);
        $cheque = IncomingCheque::findOrFail($id);
        $cheque->update(['status' => $request->status]);

        // Trigger Notification
        if (auth()->user()) {
            Notification::send(auth()->user(), new StatusAlertNotification([
                'subject'    => 'Cheque Status Updated',
                'hero_title' => 'Vault Status Update',
                'message'    => "The status of cheque N° {$cheque->cheque_number} has been updated to: " . strtoupper($request->status) . ".",
                'cta_text'   => 'View Dashboard',
                'cta_url'    => route('cheques.index')
            ]));
        }

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }

    public function endorse(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:contacts,id',
            'invoice_id'  => 'nullable|exists:invoices,id',
        ]);

        return \DB::transaction(function () use ($request, $id) {
            $cheque   = IncomingCheque::findOrFail($id);
            $supplier = \App\Models\Contact::findOrFail($request->supplier_id);

            $amountToPay = 0;

            // Logic Refinement: Handle Surplus and Remaining Balances
            if ($request->invoice_id) {
                $invoice = \App\Models\Invoice::findOrFail($request->invoice_id);
                
                // Calculate how much of the cheque we can apply to this invoice
                $invoiceRemaining = $invoice->remaining_amount; // Using the attribute from the model
                $amountToPay = min($cheque->remaining_amount, $invoiceRemaining);

                if ($amountToPay > 0) {
                    // Create the unified payment record
                    $invoice->payments()->create([
                        'method'       => 'endorsed',
                        'amount'       => $amountToPay,
                        'payment_date' => now(),
                        'payable_id'   => $cheque->id,
                        'payable_type' => get_class($cheque),
                        'notes'        => "Endossement du chèque N° {$cheque->cheque_number}",
                    ]);

                    // Update invoice status and paid balance through the unified logic
                    $invoice->updatePaidAmount();
                    
                    // Deduct from cheque's remaining amount
                    $cheque->remaining_amount -= $amountToPay;
                }
            } else {
                // No invoice selected, fully "endorse" the remaining amount as an advance
                $cheque->remaining_amount = 0;
            }

            $cheque->update([
                'status'                 => 'endorsed',
                'endorsed_to_contact_id' => $supplier->id,
                'invoice_id'             => $request->invoice_id, // Still keeping it for basic link
                'remaining_amount'       => $cheque->remaining_amount,
            ]);

            return redirect()->back()->with('success', "Endossement effectué. Le règlement a été enregistré dans l'historique.");
        });
    }
}
