<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::ordered()->paginate(15);
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'contenu' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'prix' => 'required|numeric|min:0',
            'prix_barre' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'couleur_badge' => 'nullable|string|max:20',
            'note' => 'nullable|numeric|min:0|max:5',
            'niveau' => 'nullable|string|max:50',
            'duree' => 'nullable|string|max:50',
            'lien_achat' => 'nullable|url',
            'ordre' => 'nullable|integer',
            'actif' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->boolean('actif', true);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('formations', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        unset($validated['image']);

        Formation::create($validated);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation créée avec succès !');
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'contenu' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'prix' => 'required|numeric|min:0',
            'prix_barre' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'couleur_badge' => 'nullable|string|max:20',
            'note' => 'nullable|numeric|min:0|max:5',
            'niveau' => 'nullable|string|max:50',
            'duree' => 'nullable|string|max:50',
            'lien_achat' => 'nullable|url',
            'ordre' => 'nullable|integer',
            'actif' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->boolean('actif');

        if ($request->hasFile('image')) {
            if ($formation->image_url && str_starts_with($formation->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $formation->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('formations', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        unset($validated['image']);

        $formation->update($validated);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation mise à jour avec succès !');
    }

    public function destroy(Formation $formation)
    {
        if ($formation->image_url && str_starts_with($formation->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $formation->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $formation->delete();

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation supprimée avec succès !');
    }

    public function toggleStatus(Formation $formation)
    {
        $formation->update(['actif' => !$formation->actif]);
        
        $status = $formation->actif ? 'activée' : 'désactivée';
        return redirect()->back()->with('success', "Formation {$status} avec succès !");
    }
}