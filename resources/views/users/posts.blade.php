<!-- resources/views/users/posts.blade.php -->

<!-- resources/views/users/posts.blade.php -->
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>@if($user->user_icon)<a href="{{ route('user.posts', ['user' => $user]) }}">
                <img src="{{ asset('storage/' . $user->user_icon) }}" class="img-fluid circular-profile" alt="User Icon" width="70"
                    height="70"></a>
                @else($user->defaultUserIcon)
                <img src="{{ asset('storage/' . $user->defaultUserIcon) }}" class="img-fluid circular-profile" alt="Default User Icon"
                    width="70" height="70">
                @endif{{ $user->name }}'s Profile</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">ステータスメッセージ: {{ $user->status_message ?? 'No status message' }}</h5>
        </div>
    </div>

    <h2>Posts by {{ $user->name }}</h2>

    @foreach ($user->posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title">曲名: {{ $post->title }}</h2>
            @if ($post->album)
            <p>アルバム: <a href="{{ route('albums.show', $post->album) }}">{{ $post->album }}</a></p>
            @endif
            <p class="card-text">説明: {{ $post->content }}</p>
            <p> 投稿者: @if($user->user_icon)<a href="{{ route('user.posts', ['user' => $user]) }}">
                <img src="{{ asset('storage/' . $user->user_icon) }}" class="img-fluid circular-profile" alt="User Icon" width="30"
                    height="30"></a>
                @else($user->defaultUserIcon)
                <img src="{{ asset('storage/' . $user->defaultUserIcon) }}" class="img-fluid circular-profile" alt="Default User Icon"
                    width="30" height="30">
                @endif{{ $post->user->name }}</p><!-- ユーザー名の表示 -->
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
    @endforeach

    <!-- ページネーション -->
    {{ $posts->links() }}
</div>
@endsection