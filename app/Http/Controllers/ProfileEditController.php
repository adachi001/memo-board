<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileEditController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    protected $defaultUserIcon = 'user_icon/default.png';

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'status_message']));

        // 画像の処理や保存処理を行う
        if ($request->hasFile('user_icon')) {
            $userIcon = $request->file('user_icon');
            $user->setUserIconAttribute($userIcon);
        } else {
            // ファイルがアップロードされなかった場合はデフォルトのアイコンを設定
            $user->user_icon = $this->defaultUserIcon;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'プロフィールが更新されました。');
    }
}
