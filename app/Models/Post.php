<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

use Image;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'image'];


    public function setImageAttribute($file)
    {
        $this->attributes['image'] = $file->store('images', 'public');
    }

    public function setAudioAttribute($file)
    {
        $this->attributes['audio'] = $file->store('audio', 'public');
    }
    public static function getAllPosts()
    {
        return self::latest()->get();
    }
}
