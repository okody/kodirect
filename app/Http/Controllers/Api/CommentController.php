<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //

    use GeneralTraits;

    public function index(Request $request)
    {
        $message = "All comment for the post have been brought successfully";
        $success = true;


        try {
            $comments = Comment::where("post_id", $request->post_id)->orderBy('updated_at', "DESC")->with("user:id,name,userName,profliePicture")->get();
        } catch (\Throwable $th) {
            $message = "getting all comments error: $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $comments);
    }

    public function create(Request $request)
    {

        $message = "comment have been published successfully";
        $success = true;
        $comment = null;




        try {
            $comment = Comment::create([
                "content" => $request->data["content"],
                "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->data["user_id"]),
                "post_id" => $request->post_id
            ]);
        } catch (\Exception $th) {
            $message = "Comment creating error: $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $comment);
    }


    public function get_comment(Request $request)
    {
        $message = "comment of id:$request->comment_id has been brought successfully";
        $success = true;


        try {
            $comment = Comment::where("id", $request->comment_id)->with("user:id,name,userName,profliePicture")->first();
            if (!$comment) {
                $message = "There are not comment with id:$request->comment_id";
                $success = false;
            }
        } catch (\Throwable $th) {
            $message = "Error getting comment of id:$request->comment_id \n TheError: $th";
            $success = false;
        }




        return $this->responseForm($message, $success, $comment);
    }

    public function update(Request $request)
    {

        $message = "comment with id:$request->comment_id has been updated successfully";
        $success = true;


        try {
            $comment =  Comment::find($request->comment_id);

            if (!$comment) {
                $message = "There are not comment with id:$request->comment_id";
                $success = false;
                return $this->responseForm($message, $success, $comment);
            }

            DB::table('post_comment')->where("id", $request->comment_id)->update([
                "content" => $request->data["content"],
            ]);

            $comment =  Comment::find($request->comment_id)->first();
        } catch (\Throwable $th) {
            $message = "Error updating comment $request->comment_id: \n TheError $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $comment);
    }

    public function delete(Request $request)
    {

        $message = "comment with id:$request->comment_id has been deleted successfully";
        $success = true;
        $comment = null;


        try {
            $comment =  Comment::find($request->comment_id);

            if (!$comment) {
                $message = "There are not comment with id:$request->comment_id";
                $success = false;
                return $this->responseForm($message, $success, $comment);
            }
            Comment::find($request->comment_id)->delete();
        } catch (\Throwable $th) {
            $message = "Error deleted comment $request->comment_id: \n TheError $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $comment);
    }

    /// =========================================== Local Functions =============================================
    public function deleteWithPostDelete($post_id)
    {
        $comments = Comment::where("post_id", $post_id)->get();
        foreach ($comments as $comment)
            $comment->delete();
    }
}
