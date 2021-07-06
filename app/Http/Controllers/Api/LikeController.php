<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Http\Traits\GeneralTraits;

class LikeController extends Controller
{
    //
    use GeneralTraits;

    public function create(Request $request)
    {

        $message = "post has been liked successfully";
        $status = true;


        $like = Like::create([
            "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->userID),
            "post_id" => $request->data["post_id"]
        ]);


        return $this->returnForm($message, $status, $like);
    }
}
