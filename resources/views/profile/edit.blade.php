<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>プロフィール編集</h1>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">ユーザー名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">アイコン</label>
                <input type="file" class="form-control" id="icon" name="icon">
            </div>

            <div class="mb-3">
                <label for="status_message" class="form-label">ステータスメッセージ</label>
                <textarea class="form-control" id="status_message" name="status_message">{{ old('status_message', $user->status_message) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">更新する</button>
        </form>
    </div>
@endsection

