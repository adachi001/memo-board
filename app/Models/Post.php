<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

use Image;

class Post extends Model
{
    protected $fillable = ['title', 'album', 'content', 'image', 'audio', 'user_id'];


    public function setImageAttribute($value)
    {
        $imageName = time() . '.' . $value->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('images', $value, $imageName);

        $this->attributes['image'] = 'images/' . $imageName;
    }

    public function setAudioAttribute($value)
    {
        $audioName = time() . '.' . $value->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('audio', $value, $audioName);

        $this->attributes['audio'] = 'audio/' . $audioName;
    }
    public static function getAllPosts()
    {
        return self::latest()->get();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 特定のユーザーがこの投稿にいいねしているかどうかを確認するメソッド
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
