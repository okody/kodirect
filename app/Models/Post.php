<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'imageUrl',
        'format',
        'title',
        'comment',
        'user_id',
    ];

    public function tages()
    {
        return $this->belongsToMany(Tage::class, "post_tage", "post_id", "tage_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
