<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class PublicContactController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Send to an admin email (could be configured in .env, defaulting to from address)
        Mail::to(config('mail.from.address'))->send(new ContactMessage($data));

        return back()->with('success', 'Votre message a été envoyé avec succès. Notre équipe vous contactera sous peu.');
    }
}
