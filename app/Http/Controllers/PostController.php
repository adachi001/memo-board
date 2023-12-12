<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::getAllPosts();
        $posts = Post::with('comments')->latest()->paginate(10);
        $query = Post::query();

        // 検索キーワードがある場合はタイトルで検索
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $posts = $query->latest()->paginate(10);
        return view('posts.index', compact('posts'));
        
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // バリデーションなどの適切な処理を追加

        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        // 画像の処理
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $post->setImageAttribute($image);
        }

        // mp3 ファイルの処理
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $post->setAudioAttribute($audio);
        }

        $post->save();

        return redirect('/posts')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        // ビューを返すなど、詳細を実装する
        return view('posts.show', ['post' => $post]);
    }
}