<?php
namespace App\Http\Controllers;
use App\Models\OutgoingCheque;
use App\Http\Requests\StoreOutgoingChequeRequest;
use App\Http\Requests\UpdateOutgoingChequeRequest;
use App\Http\Resources\OutgoingChequeResource;
use Illuminate\Http\Request;

class OutgoingChequeController extends Controller {
    public function index() {
        return OutgoingChequeResource::collection(OutgoingCheque::all());
    }
    public function store(StoreOutgoingChequeRequest $request) {
        $data = $request->validated(); 
        $book = \App\Models\ChequeBook::findOrFail($data["cheque_book_id"]); 
        $data["cheque_number"] = str_pad($book->current_number++, 8, "0", STR_PAD_LEFT); 
        $book->save(); 
        $cheque = OutgoingCheque::create($data); 
        return new OutgoingChequeResource($cheque);
    }
    public function show(OutgoingCheque $outgoingCheque) {
        return new OutgoingChequeResource($outgoingCheque);
    }
    public function update(UpdateOutgoingChequeRequest $request, OutgoingCheque $outgoingCheque) {
        $outgoingCheque->update($request->validated()); return new OutgoingChequeResource($outgoingCheque);
    }
    public function destroy(OutgoingCheque $outgoingCheque) {
        // Should likely not delete issued cheques easily, but adding for completeness.
        $outgoingCheque->delete(); return response()->noContent();
    }
    
}