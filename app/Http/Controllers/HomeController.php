<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Formation;
use App\Models\Category;
use App\Models\Statistique;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recentArticles  = Article::with('categorie')->where('actif', true)->latest()->take(6)->get();
        $featuredArticle = Article::with('categorie')->where('actif', true)->latest()->first();
        $formations      = Formation::where('actif', true)->latest()->take(3)->get();
        $categories      = Category::where('actif', true)->take(6)->get();
        $testimonials    = Testimonial::where('active', true)->ordered()->get();
        $statistics      = Statistique::all();
        // Alias pour les nouvelles vues qui utilisent $articles
        $articles        = $recentArticles->take(3);

        return view('home', compact(
            'articles', 'recentArticles', 'featuredArticle',
            'formations', 'categories', 'testimonials', 'statistics'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function guideGratuit()
    {
        return view('guide-gratuit');
    }
}
