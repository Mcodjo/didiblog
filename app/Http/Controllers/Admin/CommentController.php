<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        
        $query = Comment::with(['article', 'user'])->latest();
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $comments = $query->paginate(20);
        
        return view('admin.comments.index', compact('comments', 'status'));
    }

    public function approve(Comment $comment)
    {
        $comment->approve();
        return back()->with('success', 'Commentaire approuvé !');
    }

    public function reject(Comment $comment)
    {
        $comment->reject();
        return back()->with('success', 'Commentaire rejeté !');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé !');
    }
}
