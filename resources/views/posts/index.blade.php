<!-- resources/views/posts/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Post List</h1>

        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create Post</a>

        @foreach ($posts as $post)
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
                </div>
            </div>
        @endforeach
    </div>
@endsection
