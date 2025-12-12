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
        
        $query = Article::with('categorie')->active();
        
        if ($search) {
            $query->search($search);
        }
        
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->active()->first();
            if ($category) {
                $query->where('categorie_id', $category->id);
            }
        }
        
        $articles = $query->latest()->paginate(9);
        
        $categories = Category::withCount(['articles' => function ($query) {
            $query->where('actif', true);
        }])
            ->active()
            ->ordered()
            ->get();
            
        return view('blog.index', compact('articles', 'categories', 'categorySlug', 'search'));
    }

    public function show($slug)
    {
        $article = Article::with(['categorie', 'approvedComments'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
            
        $article->incrementViews();
        
        $relatedArticles = Article::with('categorie')
            ->active()
            ->where('categorie_id', $article->categorie_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();
            
        return view('blog.show', compact('article', 'relatedArticles'));
    }
}
