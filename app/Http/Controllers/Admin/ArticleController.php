<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
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

    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = Storage::url($path);
        }
        unset($validated['image']);

        $validated['slug']          = $this->uniqueSlug($validated['titre']);
        $validated['auteur']        = $validated['auteur'] ?? 'Coach Didi';
        $validated['temps_lecture'] = $validated['temps_lecture'] ?? '5 min';
        $validated['featured']      = $request->boolean('featured');
        $validated['actif']         = $request->boolean('actif', true);

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article créé avec succès !');
    }

    public function edit(Article $article)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($article->image_url);
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = Storage::url($path);
        }
        unset($validated['image']);

        $validated['slug']     = $this->uniqueSlug($validated['titre'], $article->id);
        $validated['featured'] = $request->boolean('featured');
        $validated['actif']    = $request->boolean('actif');

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article mis à jour avec succès !');
    }

    public function destroy(Article $article)
    {
        $this->deleteImage($article->image_url);
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès !');
    }

    // -------------------------------------------------------------------------
    // Helpers privés
    // -------------------------------------------------------------------------

    /**
     * Génère un slug unique en ajoutant un suffixe numérique si nécessaire.
     */
    private function uniqueSlug(string $titre, ?int $excludeId = null): string
    {
        $base  = Str::slug($titre);
        $slug  = $base;
        $count = 1;

        while (
            Article::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Supprime l'image associée à un article depuis le disque public.
     */
    private function deleteImage(?string $imageUrl): void
    {
        if (!$imageUrl) {
            return;
        }

        // Extrait le chemin relatif qu'il y ait /storage/... ou une URL complète
        $urlPath = parse_url($imageUrl, PHP_URL_PATH) ?? '';
        $path    = ltrim(str_replace('/storage', '', $urlPath), '/');

        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}