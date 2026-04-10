<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller {
    public function index() {
        return ContactResource::collection(Contact::all());
    }
    public function store(StoreContactRequest $request) {
        $contact = Contact::create($request->validated()); return new ContactResource($contact);
    }
    public function show(Contact $contact) {
        return new ContactResource($contact);
    }
    public function update(UpdateContactRequest $request, Contact $contact) {
        $contact->update($request->validated()); return new ContactResource($contact);
    }
    public function destroy(Contact $contact) {
        $contact->delete(); return response()->noContent();
    }
    
}