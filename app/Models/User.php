<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'icon',
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
    
    public function getUserIconFilenameAttribute()
    {
        // データベースに保存されているユーザーアイコンのファイル名のカラム名に合わせて修正
        return $this->attributes['user_icon'] ?? null;; 
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}