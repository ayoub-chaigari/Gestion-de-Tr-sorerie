<?php
namespace App\Http\Controllers;
use App\Models\IncomingCheque;
use App\Http\Requests\StoreIncomingChequeRequest;
use App\Http\Requests\UpdateIncomingChequeRequest;
use App\Http\Resources\IncomingChequeResource;
use Illuminate\Http\Request;

class IncomingChequeController extends Controller {
    public function index() {
        return IncomingChequeResource::collection(IncomingCheque::all());
    }
    public function store(StoreIncomingChequeRequest $request) {
        $cheque = IncomingCheque::create($request->validated()); return new IncomingChequeResource($cheque);
    }
    public function show(IncomingCheque $incomingCheque) {
        return new IncomingChequeResource($incomingCheque);
    }
    public function update(UpdateIncomingChequeRequest $request, IncomingCheque $incomingCheque) {
        $incomingCheque->update($request->validated()); return new IncomingChequeResource($incomingCheque);
    }
    public function destroy(IncomingCheque $incomingCheque) {
        $incomingCheque->delete(); return response()->noContent();
    }
    public function updateStatus(Request $request, IncomingCheque $incomingCheque) { 
        $request->validate(['status' => 'required|in:pending,deposited,paid,unpaid,endorsed', 'bank_account_id' => 'nullable|exists:bank_accounts,id']);
        $incomingCheque->update($request->only(['status', 'bank_account_id'])); return new IncomingChequeResource($incomingCheque);
    }
    public function endorse(Request $request, IncomingCheque $incomingCheque) {
        $request->validate(['supplier_id' => 'required|exists:contacts,id']);
        $incomingCheque->update(['status' => 'endorsed']);
        return response()->json(['message' => 'Cheque endorsed successfully']);
    }
}