<?php

namespace App\Http\Controllers;

use App\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::active()
            ->ordered()
            ->get();
            
        return view('formations.index', compact('formations'));
    }

    public function show($slug)
    {
        $formation = Formation::where('slug', $slug)
            ->active()
            ->firstOrFail();
            
        return view('formations.show', compact('formation'));
    }
}
