<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTokens extends Model
{
    use HasFactory;


    protected $fillable = [
        'platform',
        'token',
        "user_id"
    ];



}
