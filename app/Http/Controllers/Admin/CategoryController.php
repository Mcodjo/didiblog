<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')
            ->ordered()
            ->paginate(15);
            
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:20',
            'icone' => 'nullable|string|max:50',
            'ordre' => 'nullable|integer',
            'actif' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['couleur'] = $validated['couleur'] ?? '#f97316';
        $validated['icone'] = $validated['icone'] ?? 'fas fa-folder';
        $validated['actif'] = $request->boolean('actif', true);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:20',
            'icone' => 'nullable|string|max:50',
            'ordre' => 'nullable|integer',
            'actif' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->boolean('actif');

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}
