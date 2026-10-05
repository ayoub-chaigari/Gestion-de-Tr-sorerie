<?php

namespace App\Http\Controllers\Web\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\IncomingCheque;
use App\Models\Invoice;
use App\Models\Contact;
use Illuminate\Http\Request;

class GlobalOversightController extends Controller
{
    public function cheques(Request $request)
    {
        $query = IncomingCheque::withoutGlobalScopes()
            ->with(['company', 'contact'])
            ->latest();

        if ($request->filled('q')) {
            $query->where('cheque_number', 'like', '%' . $request->q . '%')
                  ->orWhere('bank_name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $cheques = $query->paginate(30)->appends($request->all());
        $companies = \App\Models\Company::all();

        return view('superadmin.oversight.cheques', compact('cheques', 'companies'));
    }

    public function invoices(Request $request)
    {
        $query = Invoice::withoutGlobalScopes()
            ->with(['company', 'supplier'])
            ->latest();

        if ($request->filled('q')) {
            $query->where('invoice_number', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $invoices = $query->paginate(30)->appends($request->all());
        $companies = \App\Models\Company::all();

        return view('superadmin.oversight.invoices', compact('invoices', 'companies'));
    }

    public function contacts(Request $request)
    {
        $query = Contact::withoutGlobalScopes()
            ->with('company')
            ->latest();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('ice', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $contacts = $query->paginate(30)->appends($request->all());
        $companies = \App\Models\Company::all();

        return view('superadmin.oversight.contacts', compact('contacts', 'companies'));
    }
}
