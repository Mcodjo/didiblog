<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string',
        ]);

        $article->comments()->create([
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Votre commentaire a été soumis et sera publié après modération.');
    }
}
