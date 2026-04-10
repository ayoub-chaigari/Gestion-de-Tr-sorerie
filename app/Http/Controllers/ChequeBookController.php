<?php
namespace App\Http\Controllers;
use App\Models\ChequeBook;
use App\Http\Requests\StoreChequeBookRequest;
use App\Http\Requests\UpdateChequeBookRequest;
use App\Http\Resources\ChequeBookResource;
use Illuminate\Http\Request;

class ChequeBookController extends Controller {
    public function index() {
        return ChequeBookResource::collection(ChequeBook::all());
    }
    public function store(StoreChequeBookRequest $request) {
        $data = $request->validated(); $data['current_number'] = $data['start_number']; $book = ChequeBook::create($data); return new ChequeBookResource($book);
    }
    public function show(ChequeBook $chequeBook) {
        return new ChequeBookResource($chequeBook);
    }
    public function update(UpdateChequeBookRequest $request, ChequeBook $chequeBook) {
        $chequeBook->update($request->validated()); return new ChequeBookResource($chequeBook);
    }
    public function destroy(ChequeBook $chequeBook) {
        $chequeBook->delete(); return response()->noContent();
    }
    
}