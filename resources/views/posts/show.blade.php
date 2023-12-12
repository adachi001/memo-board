<!-- resources/views/posts/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Post List</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create Post</a>
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->content }}</p>

            @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid" alt="Post Image" width="70" height="70">
            @endif

            @if ($post->audio)
            <audio controls>
                <source src="{{ asset('storage/' . $post->audio) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            @endif

            <!-- コメントの表示 -->
            <div class="mt-3">
                <strong>Comments:</strong>
                @foreach ($post->comments as $comment)
                <p>{{ $post->user->name }}:  {{ $comment->body }}</p>
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