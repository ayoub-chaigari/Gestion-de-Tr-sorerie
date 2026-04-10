<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\IncomingCheque;
use App\Models\Effet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:invoices,create')->only(['store']);
        $this->middleware('permission:invoices,delete')->only(['destroy']);
    }

    /**
     * Store a new payment for a specific invoice.
     */
    public function store(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $invoice->remaining_amount,
            'method' => 'required|in:cash,virement,cheque,effet',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            // Specific fields for Cheque/Effet if the user wants to create them on the fly
            'reference_number' => 'required_if:method,cheque,effet|nullable|string',
            'due_date' => 'required_if:method,cheque,effet|nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $payable = null;

            // Handle Cheque/Effet specific logic
            if ($request->method === 'cheque') {
                // In a real app, you might select an existing cheque. 
                // For this example, we'll create a record representing the cheque used.
                $payable = IncomingCheque::create([
                    'company_id' => $invoice->company_id,
                    'contact_id' => $invoice->supplier_id, // For supplier payments, we might use an endorsed cheque
                    'amount' => $request->amount,
                    'cheque_number' => $request->reference_number,
                    'due_date' => $request->due_date,
                    'status' => 'pending',
                ]);
            } elseif ($request->method === 'effet') {
                $payable = Effet::create([
                    'company_id' => $invoice->company_id,
                    'supplier_id' => $invoice->supplier_id,
                    'amount' => $request->amount,
                    'effet_number' => $request->reference_number,
                    'due_date' => $request->due_date,
                    'status' => 'pending',
                ]);
            }

            // Create the unified payment record
            $payment = $invoice->payments()->create([
                'method' => $request->method,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes,
                'payable_id' => $payable ? $payable->id : null,
                'payable_type' => $payable ? get_class($payable) : null,
            ]);

            // Update the invoice status and paid_amount
            $invoice->updatePaidAmount();

            DB::commit();

            return redirect()->back()->with('success', 'Paiement enregistré avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /**
     * Optional: Delete a payment and update the invoice balance.
     */
    public function destroy(InvoicePayment $payment)
    {
        $invoice = $payment->invoice;
        $payment->delete();
        $invoice->updatePaidAmount();

        return redirect()->back()->with('success', 'Paiement supprimé.');
    }
}
