<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTages extends Model
{
    use HasFactory;

    protected $table = "post_tage";

    protected $fillable = [
        'tage_id',
        'post_id',

    ];
}
