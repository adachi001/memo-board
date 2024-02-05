<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_icon',
        'status_message',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }

    // ユーザーが特定の投稿にいいねしているかどうかを確認するメソッド
    public function hasLiked(Post $post)
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }
    protected $defaultUserIcon = 'user_icon/default.png';


    public function setUserIconAttribute($value)
{
    if (is_string($value)) {
        // 既にファイルパスが渡されている場合の処理
        $this->attributes['user_icon'] = $value;
    } elseif ($value) {
        // アップロードされたファイルの場合の処理
        $userIconName = time() . '.' . $value->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('user_icon', $value, $userIconName);
        $this->attributes['user_icon'] = 'user_icon/' . $userIconName;
    } else {
        // デフォルトのアイコンなど、適切な処理を追加
        $this->attributes['user_icon'] = asset('storage/' . $this->defaultUserIcon);
    }
}





    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}