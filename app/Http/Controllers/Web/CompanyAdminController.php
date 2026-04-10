<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyAdminController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('users')->get();
        return view('companies.index', compact('companies'));
    }

    public function activate($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => 'active']);
        return redirect()->back()->with('success', "Entreprise '{$company->name}' activée.");
    }

    public function suspend($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => 'suspended']);
        return redirect()->back()->with('success', "Entreprise '{$company->name}' suspendue.");
    }
}
