<?php
// app/Http/Controllers/ProfileEditController.php

// app/Http/Controllers/ProfileEditController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileEditController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'status_message']));

        // 画像の処理や保存処理を行う
        if ($request->hasFile('user_icon')) {
            $userIcon = $request->file('user_icon');
            $filename = time() . '.' . $userIcon->getClientOriginalExtension();
            $location = public_path('path/to/save/directory/' . $filename);
            $userIcon->move('path/to/save/directory/', $filename);

            // ユーザーのプロフィールに画像のパスを保存
            $user->img_path = $filename;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'プロフィールが更新されました。');
    }
}
