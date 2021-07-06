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

    ];


    public function posts()
    {
        return $this->belongsToMany(Post::class, "post_tage", "tage_id", "post_id");
    }
}
