<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::withCount('chequeBooks')->get();
        return view('treasury.bank_accounts.index', compact('bankAccounts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:255',
            'agency' => 'nullable|string',
            'rib' => 'required|string|size:24',
        ]);

        BankAccount::create($data);
        return redirect()->back()->with('success', 'Compte bancaire ajouté.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->back()->with('success', 'Compte bancaire supprimé.');
    }
}
