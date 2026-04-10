<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;

class CompanyController extends Controller {
    public function index() {
        return CompanyResource::collection(Company::all());
    }
    public function store(StoreCompanyRequest $request) {
        $company = Company::create($request->validated()); return new CompanyResource($company);
    }
    public function show(Company $company) {
        return new CompanyResource($company);
    }
    public function update(UpdateCompanyRequest $request, Company $company) {
        $company->update($request->validated()); return new CompanyResource($company);
    }
    public function destroy(Company $company) {
        $company->delete(); return response()->noContent();
    }
    public function activate(Company $company) { $company->update(['status' => 'active']); return new CompanyResource($company); }
    public function suspend(Company $company) { $company->update(['status' => 'suspended']); return new CompanyResource($company); }
}