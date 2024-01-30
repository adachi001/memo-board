<?php

// app/Http/Controllers/UserController.php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function posts(User $user)
    {
        $posts = $user->posts()->latest()->paginate(10);
        return view('users.posts', compact('user', 'posts'));
    }
    public function showProfile($id)
{
    $user = User::findOrFail($id);
    return view('users.profile', compact('user'));
}
}
