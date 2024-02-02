<?php
// app/Http/Controllers/AlbumController.php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    // 既存のコード...

    public function show($album)
{
    // アルバム名に基づいて該当する投稿を取得
    $posts = Post::where('album', $album)->get();

    // 例えば、最初の投稿のユーザーオブジェクトを取得
    $user = $posts->first()->user;

    return view('albums.show', compact('album', 'posts', 'user'));
}

}
