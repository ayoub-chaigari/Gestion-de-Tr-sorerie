<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        return UserResource::collection(User::all());
    }
    public function store(StoreUserRequest $request) {
        $data = $request->validated(); $data['password'] = bcrypt($data['password']); $user = User::create($data); return new UserResource($user);
    }
    public function show(User $user) {
        return new UserResource($user);
    }
    public function update(UpdateUserRequest $request, User $user) {
        $data = $request->validated(); if(isset($data['password'])) $data['password'] = bcrypt($data['password']); $user->update($data); return new UserResource($user);
    }
    public function destroy(User $user) {
        $user->delete(); return response()->noContent();
    }
    
}