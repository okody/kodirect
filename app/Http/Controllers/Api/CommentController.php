<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;

class CommentController extends Controller
{
    //

    use GeneralTraits;

    public function create(Request $request)
    {

        $message = "comment have been published successfully";
        $status = true;


        $comment = Comment::create([
            "content" => $request->data["content"],
            "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->userID),
            "post_id" => $request->data["post_id"]
        ]);



        return $this->returnForm($message, $status, $comment);
    }
}
