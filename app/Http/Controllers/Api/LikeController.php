<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    //

    use GeneralTraits;

    public function index()
    {
        $message = "All like for the post have been brought successfully";
        $success = true;


        try {
            $likes = Like::with("user:id,name,userName,profliePicture")->get();
        } catch (\Throwable $th) {
            $message = "getting all likes error: $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $likes);
    }

    public function create(Request $request)
    {

        $message = "like have been published successfully";
        $success = true;
        $like = null;




        try {
            $like = Like::create([
                "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->header('user_id')),
                "post_id" => $request->post_id
            ]);
        } catch (\Throwable $th) {
            $message = "Like creating error: $th";
            $success = false;
        }

        return $this->responseForm($message, $success, $like);
    }


    public function get_like(Request $request)
    {
        $message = "like of id:$request->like_id has been brought successfully";
        $success = true;


        try {
            $like = Like::where("id", $request->like_id)->with("user:id,name,userName,profliePicture")->first();
            if (!$like) {
                $message = "There are not like with id:$request->like_id";
                $success = false;
            }
        } catch (\Throwable $th) {
            $message = "Error getting like of id:$request->like_id \n TheError: $th";
            $success = false;
        }




        return $this->responseForm($message, $success, $like);
    }



    public function delete(Request $request)
    {

        $message = "like with id:$request->like_id has been deleted successfully";
        $success = true;
        $like = null;


        try {
            $like =  Like::find($request->like_id);

            if (!$like) {
                $message = "There are not like with id:$request->like_id";
                $success = false;
                return $this->responseForm($message, $success, $like);
            }
            Like::find($request->like_id)->delete();
        } catch (\Throwable $th) {
            $message = "Error deleted like $request->like_id: \n TheError $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $like);
    }

    /// =========================================== Local Functions =============================================
    public function deleteWithPostDelete($post_id)
    {
        $likes = Like::where("post_id", $post_id)->get();
        foreach ($likes as $like)
            $like->delete();
    }
}
