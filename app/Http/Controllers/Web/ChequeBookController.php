<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ChequeBook;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class ChequeBookController extends Controller
{
    public function index()
    {
        $chequeBooks = ChequeBook::with('bankAccount')->get();
        return view('treasury.cheque_books.index', compact('chequeBooks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer|gt:start_number',
        ]);

        $data['current_number'] = $data['start_number'];
        $data['company_id'] = auth()->user()->company_id;
        
        ChequeBook::create($data);
        return redirect()->back()->with('success', 'Carnet de chèques ajouté.');
    }

    public function destroy(ChequeBook $chequeBook)
    {
        $chequeBook->delete();
        return redirect()->back()->with('success', 'Carnet de chèques supprimé.');
    }
}
