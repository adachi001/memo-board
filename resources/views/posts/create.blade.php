<!-- resources/views/posts/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Create a New Post</h1>

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <div class="form-group">
            <label for="album">アルバム</label>
            <input type="text" name="album" class="form-control" value="{{ old('album') }}"
                placeholder="アルバム名を入力してください">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea class="form-control" name="content" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" name="image">
        </div>

        <div class="mb-3">
            <label for="audio" class="form-label">Audio (mp3):</label>
            <input type="file" class="form-control" name="audio">
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">動画ファイル:</label>
            <input type="file" class="form-control" name="video" accept="video/*">
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
@endsection