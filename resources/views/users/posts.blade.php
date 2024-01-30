<!-- resources/views/users/posts.blade.php -->

<!-- resources/views/users/posts.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>{{ $user->name }}'s Profile</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">ステータスメッセージ: {{ $user->status_message ?? 'No status message' }}</h5>
            @if ($user->icon)
                <img src="{{ asset('path/to/save/directory/' . $user->icon) }}" alt="User Icon" width="50" height="50">
            @else
                <!-- デフォルトのアイコンが存在しない場合の代替として何か表示する -->
                <img src="{{ asset('path/to/default/icon.jpg') }}" alt="Default Icon" width="50" height="50">
            @endif
        </div>
    </div>

    <h2>Posts by {{ $user->name }}</h2>

    @foreach ($user->posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <p class="card-text">{{ $post->content }}</p>
            <p>投稿者: {{ $user->name }}</p>
            <p>投稿日時: {{ $post->created_at }}</p>

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