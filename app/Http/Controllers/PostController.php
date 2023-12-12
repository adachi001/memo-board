<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user')->get();
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

        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            // 他のフィールドをここで追加
            'user_id' => Auth::id(), // ログインユーザーのIDを取得して関連付ける
        ]);

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

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }
}