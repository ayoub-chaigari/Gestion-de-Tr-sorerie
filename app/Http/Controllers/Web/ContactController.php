<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('name')->paginate(15);
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:client,supplier',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'ice' => 'required|string|size:15', // Law 69-21 compliance
            'if' => 'nullable|string|max:9',
            'rc' => 'required|string|max:255',
        ]);

        Contact::create($data);
        return redirect()->route('contacts.index')->with('success', 'Contact ajouté avec succès.');
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'type' => 'required|in:client,supplier',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'ice' => 'required|string|size:15',
            'if' => 'nullable|string|max:9',
            'rc' => 'required|string|max:255',
        ]);

        $contact->update($data);
        return redirect()->route('contacts.index')->with('success', 'Contact mis à jour avec succès.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact supprimé.');
    }
}
