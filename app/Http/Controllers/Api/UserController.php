<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index()
    {
    }

    public function create(Request $request)
    {

        return  [
            "message" =>  "You reach the api server cong",
            "data" => ["userName" => "SamHunter"],
            "status" => true
        ];
    }
}
