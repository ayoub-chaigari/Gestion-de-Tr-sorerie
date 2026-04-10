<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OutgoingCheque;
use App\Models\ChequeBook;
use App\Models\Contact;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutgoingChequeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cheques,view')->only(['index']);
        $this->middleware('permission:cheques,create')->only(['create', 'store', 'updateStatus']);
    }

    public function index()
    {
        $outgoingCheques = OutgoingCheque::with(['contact', 'chequeBook.bankAccount'])->orderBy('created_at', 'desc')->paginate(15);
        return view('cheques.outgoing.index', compact('outgoingCheques'));
    }

    public function create()
    {
        $suppliers = Contact::where('type', 'supplier')->get();
        $chequeBooks = ChequeBook::with('bankAccount')->where('current_number', '<=', DB::raw('end_number'))->get();
        $invoices = \App\Models\Invoice::whereIn('status', ['pending', 'partial', 'overdue'])->get();
        return view('cheques.outgoing.create', compact('suppliers', 'chequeBooks', 'invoices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id'    => 'required|exists:contacts,id',
            'cheque_book_id'=> 'required|exists:cheque_books,id',
            'invoice_id'    => 'nullable|exists:invoices,id',
            'amount'        => 'required|numeric|min:0.01',
            'due_date'      => 'required|date',
        ]);

        return DB::transaction(function () use ($data) {
            $book = ChequeBook::lockForUpdate()->findOrFail($data['cheque_book_id']);

            if ($book->current_number > $book->end_number) {
                return redirect()->back()->withErrors(['cheque_book_id' => 'Ce carnet est épuisé.'])->withInput();
            }

            $data['cheque_number'] = str_pad($book->current_number, 8, '0', STR_PAD_LEFT);
            $data['status']        = 'pending';

            $outgoingCheque = OutgoingCheque::create($data);

            // Increment carnet number
            $book->increment('current_number');

            return redirect()->route('outgoing-cheques.index')->with('success', "Chèque n° {$data['cheque_number']} émis et en attente.");
        });
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,paid,unpaid']);
        $cheque = OutgoingCheque::findOrFail($id);
        $oldStatus = $cheque->status;
        $newStatus = $request->status;

        return DB::transaction(function () use ($cheque, $oldStatus, $newStatus) {
            $cheque->update(['status' => $newStatus]);

            // If status changed to PAID, create a payment record
            if ($newStatus === 'paid' && $oldStatus !== 'paid' && $cheque->invoice_id) {
                $invoice = $cheque->invoice;
                
                $invoice->payments()->create([
                    'method'       => 'cheque',
                    'amount'       => $cheque->amount,
                    'payment_date' => now(),
                    'payable_id'   => $cheque->id,
                    'payable_type' => get_class($cheque),
                    'notes'        => "Paiement par chèque émis N° {$cheque->cheque_number}",
                ]);

                $invoice->updatePaidAmount();
            }

            // If status changed FROM paid TO something else, delete the payment record
            if ($oldStatus === 'paid' && $newStatus !== 'paid' && $cheque->invoice_id) {
                $invoice = $cheque->invoice;
                
                // Find the payment linked to this cheque and delete it
                $invoice->payments()
                    ->where('payable_id', $cheque->id)
                    ->where('payable_type', get_class($cheque))
                    ->delete();

                $invoice->updatePaidAmount();
            }

            return redirect()->back()->with('success', 'Statut du chèque mis à jour avec succès.');
        });
    }
}
