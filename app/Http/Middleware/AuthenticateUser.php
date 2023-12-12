<?php

// app/Http/Middleware/AuthenticateUser.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next)
    {
        // ログインしているかどうかを確認
        if (Auth::check()) {
            return $next($request); // ログインしていれば次の処理に進む
        }

        // ログインしていない場合はリダイレクト（例: ログインページにリダイレクト）
        return redirect('/login');
    }
}
