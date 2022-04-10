<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imageUrl',
        'bakcgroundUrl',
        "description",

    ];

    public function tages()
    {
        return $this->belongsToMany(Tage::class, "user_tage", "user_id", "tage_id");
    }


    public function posts()
    {
        return $this->belongsToMany(Post::class, "post_tage", "tage_id", "post_id");
    }
}
