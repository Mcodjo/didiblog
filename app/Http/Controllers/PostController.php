<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return view('posts.show', compact('post'));
    }
}
