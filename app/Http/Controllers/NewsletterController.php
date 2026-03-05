<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'source' => 'nullable|string|max:50',
        ]);

        Newsletter::create([
            'email' => $validated['email'],
            'source' => $validated['source'] ?? 'website',
        ]);

        return back()->with('success', 'Merci pour votre inscription à la newsletter !');
    }
}
