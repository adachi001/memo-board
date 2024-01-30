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
        <button href="{{ route('posts.index') }}">戻る</button>
        <!-- ソートリンク -->
        <div>
            <a href="{{ route('posts.index', ['sort_by' => 'created_at', 'sort_order' => 'desc']) }}">新しい順</a>
            <a href="{{ route('posts.index', ['sort_by' => 'created_at', 'sort_order' => 'asc']) }}">古い順</a>
            <a href="{{ route('posts.index', ['sort_by' => 'likes_count', 'sort_order' => 'desc']) }}">いいね数順</a>
        </div>
    </form>

    @foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->content }}</p>
            <a href="{{ route('user.posts', $user) }}">{{ $post->user->name }}</a><!-- ユーザー名の表示 -->
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
            <p>{{ $post->user->name }}: {{ $comment->body }}</p>
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