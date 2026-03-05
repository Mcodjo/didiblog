<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Formation;
use App\Models\Newsletter;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'categories' => Category::count(),
            'formations' => Formation::count(),
            'users' => User::count(),
            'comments' => Comment::count(),
            'pending_comments' => Comment::pending()->count(),
            'newsletters' => Newsletter::count(),
            'contacts' => Contact::unread()->count(),
        ];
        
        $recentArticles = Article::with('categorie')
            ->latest()
            ->take(5)
            ->get();
            
        $recentComments = Comment::with(['article', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentComments'));
    }
}
