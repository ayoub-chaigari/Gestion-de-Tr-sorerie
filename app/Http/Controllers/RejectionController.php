<?php
namespace App\Http\Controllers;
use App\Models\Rejection;
use App\Http\Requests\StoreRejectionRequest;
use App\Http\Requests\UpdateRejectionRequest;
use App\Http\Resources\RejectionResource;
use Illuminate\Http\Request;

class RejectionController extends Controller {
    public function index() {
        return RejectionResource::collection(Rejection::all());
    }
    public function store(StoreRejectionRequest $request) {
        $rejection = Rejection::create($request->validated()); return new RejectionResource($rejection);
    }
    public function show(Rejection $rejection) {
        return new RejectionResource($rejection);
    }
    public function update(UpdateRejectionRequest $request, Rejection $rejection) {
        $rejection->update($request->validated()); return new RejectionResource($rejection);
    }
    public function destroy(Rejection $rejection) {
        $rejection->delete(); return response()->noContent();
    }
    public function resolve(Rejection $rejection) { $rejection->update(['resolved' => true]); return new RejectionResource($rejection); }
    public function toLitigation(Rejection $rejection) { $rejection->update(['sent_to_litigation' => true]); return new RejectionResource($rejection); }
}