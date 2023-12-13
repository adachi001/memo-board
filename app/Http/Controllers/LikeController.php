<?php

// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        // すでにいいねしているか確認
        $existingLike = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();

        if (!$existingLike) {
            // いいねしていない場合は新しくいいねを作成
            $like = new Like(['user_id' => Auth::id()]);
            $post->likes()->save($like);
        }

        return back();
    }

    public function unlike(Post $post)
    {
        // いいねを取り消す
        Like::where('user_id', Auth::id())->where('post_id', $post->id)->delete();

        return back();
    }
}
