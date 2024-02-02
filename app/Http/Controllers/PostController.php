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
        $posts = Post::with('user')->get(); // 冗長なクエリ
        $posts = Post::getAllPosts(); // 冗長なクエリ
        $posts = Post::with('comments')->latest()->paginate(10); // 冗長なクエリ
        $query = Post::query();
        $query = Post::with('user'); // 冗長なクエリ
        $posts = Post::with('user')->latest()->paginate(10);


        // ユーザー情報を取得
        $user = Auth::user();

        // 検索キーワードがある場合はタイトルで検索
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // ソートの条件を確認
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        // いいね数でソート
        if ($sortBy === 'likes_count') {
            $query->withCount('likes')->orderBy('likes_count', $sortOrder);
        } else {
            // 投稿日時でデフォルトソート
            $query->orderBy($sortBy, $sortOrder);
        }


        $posts = $query->latest()->paginate(10);
        return view('posts.index', compact('posts', 'user'));

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
            'album' => $request->input('album'),
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