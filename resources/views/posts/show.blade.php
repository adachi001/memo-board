<!-- resources/views/posts/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Post List</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create Post</a>
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title">曲名: {{ $post->title }}</h2>
            @if ($post->album)
            <p>アルバム: <a href="{{ route('albums.show', $post->album) }}">{{ $post->album }}</a></p>
            @endif
            <p class="card-text">説明: {{ $post->content }}</p>
            <p> 投稿者: <a href="{{ route('user.posts', $post->user) }}">{{ $post->user->name }}</a></p><!-- ユーザー名の表示 -->
            <p>投稿日時: {{ $post->created_at }}</p>
            <!-- いいねボタン -->
            @auth
            @if($post->isLikedBy(auth()->user()))
            <form action="{{ route('posts.unlike', $post) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit">いいねを取り消す</button>
            </form>
            @else
            <form action="{{ route('posts.like', $post) }}" method="post">
                @csrf
                <button type="submit">いいね</button>
            </form>
            @endif
            @endauth

            <!-- いいね数の表示 -->
            <p>いいね数: {{ $post->likesCount() }}</p>

            <!-- 他の表示内容や操作ボタンを追加 -->

            @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid" alt="Post Image" width="70" height="70">
            @endif

            @if ($post->audio)
            <audio controls>
                <source src="{{ asset('storage/' . $post->audio) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            @endif
            
            @if ($post->video)
            <video width="320" height="240" controls>
                <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            @endif
        </div>

        <!-- コメントの表示 -->
        <div class="mt-3">
            <strong>Comments:</strong>
            @foreach ($post->comments as $comment)
            <p>{{ $post->user->name }}: {{ $comment->body }}</p>
            @endforeach
        </div>

        <!-- コメントの投稿フォーム -->
        <form action="{{ route('comments.store', $post) }}" method="post" class="mt-3">
            @csrf
            <div class="form-group">
                <label for="body">Add a comment:</label>
                <textarea name="body" id="body" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
            <a href="{{ route('posts.index') }}" class="btn btn-primary">一覧に戻る</a>
        </form>
        @endsection