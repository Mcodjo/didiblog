<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Formation;
use App\Models\Statistique;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredArticle = Article::with('categorie')
            ->active()
            ->featured()
            ->latest()
            ->first();
            
        $recentArticles = Article::with('categorie')
            ->active()
            ->latest()
            ->take(4)
            ->get();
        
        $articles = Article::with('categorie')
            ->active()
            ->latest()
            ->skip(4)
            ->take(6)
            ->get();
            
        $categories = Category::withCount(['articles' => function ($query) {
            $query->where('actif', true);
        }])
            ->active()
            ->ordered()
            ->get();
            
        $formations = Formation::active()
            ->ordered()
            ->get();
            
        $statistics = Statistique::active()
            ->ordered()
            ->get();

        $quiSuisJe = [
            'title' => SiteSetting::get('qui_suis_je_title', 'Coach Didi, ton expert en employabilité'),
            'description1' => SiteSetting::get('qui_suis_je_description1', 'Bonjour ! Je suis <strong>Cadnel DOSSOU</strong>, plus connu sous le nom de <strong>Coach Didi</strong>. Depuis plus de 8 ans, j\'accompagne les étudiants et jeunes diplômés dans leur recherche d\'emploi.'),
            'description2' => SiteSetting::get('qui_suis_je_description2', 'Ma mission ? T\'aider à décrocher l\'emploi de tes rêves plus rapidement et efficacement grâce à des méthodes éprouvées et un accompagnement personnalisé.'),
            'image' => SiteSetting::get('qui_suis_je_image', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'),
            'stat1_value' => SiteSetting::get('qui_suis_je_stat1_value', '4 300+'),
            'stat1_label' => SiteSetting::get('qui_suis_je_stat1_label', 'Personnes accompagnées'),
            'stat2_value' => SiteSetting::get('qui_suis_je_stat2_value', '85%'),
            'stat2_label' => SiteSetting::get('qui_suis_je_stat2_label', 'Taux de réussite'),
        ];

        return view('home', compact(
            'featuredArticle',
            'recentArticles',
            'articles',
            'categories',
            'formations',
            'statistics',
            'quiSuisJe'
        ));
    }

    public function about()
    {
        $about = [
            'title' => SiteSetting::get('about_title', 'Bonjour, je suis Cadnel DOSSOU'),
            'description' => SiteSetting::get('about_description', 'Plus connu sous le nom de <strong class="text-orange-600">Coach Didi</strong>, je suis passionné par l\'accompagnement des jeunes dans leur recherche d\'emploi. Depuis plus de 8 ans, j\'aide les étudiants et jeunes diplômés à décrocher leur premier emploi ou à réorienter leur carrière. Ma méthode ? Un accompagnement personnalisé, des conseils pratiques et une énergie positive !'),
            'image' => SiteSetting::get('about_image', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'),
            'stat1_value' => SiteSetting::get('about_stat1_value', '4 300+'),
            'stat1_label' => SiteSetting::get('about_stat1_label', 'Personnes accompagnées'),
            'stat2_value' => SiteSetting::get('about_stat2_value', '85%'),
            'stat2_label' => SiteSetting::get('about_stat2_label', 'Taux de réussite'),
            'stat3_value' => SiteSetting::get('about_stat3_value', '8+'),
            'stat3_label' => SiteSetting::get('about_stat3_label', 'Années d\'expérience'),
            'stat4_value' => SiteSetting::get('about_stat4_value', '5'),
            'stat4_label' => SiteSetting::get('about_stat4_label', 'Formations disponibles'),
        ];
        
        return view('about', compact('about'));
    }

    public function guideGratuit()
    {
        return view('guide-gratuit');
    }
}