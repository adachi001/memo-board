<!-- resources/views/posts/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Post List</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create Post</a>
    <!-- 検索フォーム -->
    <form action="{{ route('posts.index') }}" method="GET">
        <input type="text" name="search" placeholder="タイトルを検索">
        <button type="submit">検索</button>
        <button href="{{ route('posts.index') }}" >戻る</button>

    </form>

    @foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->content }}</p>
            <p>投稿者: {{ $post->user->name }}</p> <!-- ユーザー名の表示 -->

            @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid" alt="Post Image" width="70" height="70">
            @endif

            @if ($post->audio)
            <audio controls>
                <source src="{{ asset('storage/' . $post->audio) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            @endif
        </div>
        <!-- コメントの表示 -->
        <div class="mt-3">
            <strong>Comments:</strong>
            @foreach ($post->comments->take(3) as $comment)
            <p>{{ $comment->body }}</p>
            @endforeach

            @if ($post->comments->count() > 3)
            <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                <p>他 {{ $post->comments->count() - 3 }} 件のコメントがあります。</p>
            </a>
            @endif

        </div>
        <!-- コメントの投稿フォーム -->
        <form action="{{ route('comments.store', $post) }}" method="post" class="mt-3">
            @csrf
            <div class="form-group">
                <label for="body">Add a comment:</label>
                <textarea name="body" id="body" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>
    <!-- ページネーション -->
    {{ $posts->links() }}
    @endforeach
</div>
@endsection