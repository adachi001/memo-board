<!-- resources/views/profile/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}'s Profile</div>

                <div class="card-body">
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Status Message: {{ $user->status_message }}</p>
                    <p>Profile Image: @if($user->user_icon)
                        <!-- profile/show.blade.php などの表示画面での例 -->
                        <img src="{{ asset('path/to/save/directory/' . Auth::user()->img_path) }}" alt="User Icon">

                        @else
                    <p>No user icon available.</p>
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