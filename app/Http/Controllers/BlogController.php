<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->get('category');
        $search = $request->get('search');

        $query = Article::with('categorie')->where('actif', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('contenu', 'like', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->where('actif', true)->first();
            if ($category) {
                $query->where('categorie_id', $category->id);
            }
        }

        $articles = $query->latest()->paginate(9);

        $featured = Article::where('actif', true)->where('featured', true)->first();
        if (!$featured && $articles->isNotEmpty()) {
            $featured = $articles->first();
        }

        $categories = Category::withCount(['articles' => function ($q) {
            $q->where('actif', true);
        }])->where('actif', true)->get();

        return view('blog.index', compact('articles', 'categories', 'categorySlug', 'search', 'featured'));
    }

    public function show($slug)
    {
        $article = Article::with(['categorie', 'approvedComments'])
            ->where('slug', $slug)
            ->where('actif', true)
            ->firstOrFail();

        $article->increment('vues');

        $relatedArticles = Article::with('categorie')
            ->where('categorie_id', $article->categorie_id)
            ->where('id', '!=', $article->id)
            ->where('actif', true)
            ->limit(3)
            ->get();

        return view('blog.show', compact('article', 'relatedArticles'));
    }
}
