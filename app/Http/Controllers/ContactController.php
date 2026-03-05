<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}
