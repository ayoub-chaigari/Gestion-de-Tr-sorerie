<?php
namespace App\Http\Controllers;
use App\Models\BankAccount;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;
use App\Http\Resources\BankAccountResource;
use Illuminate\Http\Request;

class BankAccountController extends Controller {
    public function index() {
        return BankAccountResource::collection(BankAccount::all());
    }
    public function store(StoreBankAccountRequest $request) {
        $account = BankAccount::create($request->validated()); return new BankAccountResource($account);
    }
    public function show(BankAccount $bankAccount) {
        return new BankAccountResource($bankAccount);
    }
    public function update(UpdateBankAccountRequest $request, BankAccount $bankAccount) {
        $bankAccount->update($request->validated()); return new BankAccountResource($bankAccount);
    }
    public function destroy(BankAccount $bankAccount) {
        $bankAccount->delete(); return response()->noContent();
    }
    
}