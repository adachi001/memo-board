<!-- resources/views/profile/show.blade.php -->

@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}'s Profile</div>

                <div class="card-body">
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Status Message: {{ $user->status_message }}</p>
                    <p>Profile Image:
                        @if($user->user_icon)
                        <img src="{{ asset('storage/' . $user->user_icon) }}" class="img-fluid circular-profile" alt="User Icon"
                            width="30" height="30">
                        @else($user->defaultUserIcon)
                        <img src="{{ asset('storage/' . $user->defaultUserIcon) }}" class="img-fluid circular-profile"
                            alt="Default User Icon" width="30" height="30">
                        @endif
                </div>
            </div>
            <a href="{{ route('posts.index') }}">一覧に戻る</a>

            <!-- プロフィール編集へのリンク -->
            <a href="{{ route('profile.edit') }}">プロフィール編集</a>
        </div>
    </div>
</div>
@endsection