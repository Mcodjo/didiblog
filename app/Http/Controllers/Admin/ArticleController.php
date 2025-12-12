<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('categorie')
            ->latest()
            ->paginate(15);
            
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'extrait' => 'required|string',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categorie_id' => 'required|exists:categories,id',
            'auteur' => 'nullable|string|max:255',
            'temps_lecture' => 'nullable|string|max:20',
            'featured' => 'boolean',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        unset($validated['image']);

        $validated['slug'] = Str::slug($validated['titre']);
        $validated['auteur'] = $validated['auteur'] ?? 'Coach Didi';
        $validated['temps_lecture'] = $validated['temps_lecture'] ?? '5 min';
        $validated['featured'] = $request->boolean('featured');
        $validated['actif'] = $request->boolean('actif', true);

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article créé avec succès !');
    }

    public function edit(Article $article)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'extrait' => 'required|string',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categorie_id' => 'required|exists:categories,id',
            'auteur' => 'nullable|string|max:255',
            'temps_lecture' => 'nullable|string|max:20',
            'featured' => 'boolean',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($article->image_url && str_starts_with($article->image_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $article->image_url));
            }
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        unset($validated['image']);

        $validated['slug'] = Str::slug($validated['titre']);
        $validated['featured'] = $request->boolean('featured');
        $validated['actif'] = $request->boolean('actif');

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article mis à jour avec succès !');
    }

    public function destroy(Article $article)
    {
        if ($article->image_url && str_starts_with($article->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->image_url));
        }
        
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès !');
    }
}