<?php

// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $post->comments()->create([
            'body' => $request->input('body'),
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully!');
    }

    public function show(Post $post)
    {
        // 特定の投稿に対するコメントを取得
        $comments = $post->comments;

        return view('comments.show', compact('post', 'comments'));
    }
}
