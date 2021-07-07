<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $table = "post_view";


    protected $fillable = [
        "user_id",
        "post_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
