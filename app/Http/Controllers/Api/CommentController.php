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

    public function index()
    {
        $message = "All comment for the post have been brought successfully";
        $status = true;


        try {
            $comments = Comment::with("user:id,name,userName,profliePicture")->get();
        } catch (\Throwable $th) {
            $message = "getting all comments error: $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $comments);
    }

    public function create(Request $request)
    {

        $message = "comment have been published successfully";
        $status = true;


        try {
            $comment = Comment::create([
                "content" => $request->data["content"],
                "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->userID),
                "post_id" => $request->post_id
            ]);
        } catch (\Throwable $th) {
            $message = "Comment creating error: $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $comment);
    }


    public function get_comment(Request $request)
    {
        $message = "comment of id:$request->comment_id has been brought successfully";
        $status = true;


        try {
            $comment = Comment::where("id", $request->comment_id)->with("user:id,name,userName,profliePicture")->first();
            if (!$comment) {
                $message = "There are not comment with id:$request->comment_id";
                $status = false;
            }
        } catch (\Throwable $th) {
            $message = "Error getting comment of id:$request->comment_id \n TheError: $th";
            $status = false;
        }




        return $this->returnForm($message, $status, $comment);
    }

    public function update(Request $request)
    {

        $message = "comment with id:$request->comment_id has been updated successfully";
        $status = true;


        try {
            $comment =  Comment::find($request->comment_id);

            if (!$comment) {
                $message = "There are not comment with id:$request->comment_id";
                $status = false;
                return $this->returnForm($message, $status, $comment);
            }

            DB::table('post_comment')->where("id", $request->comment_id)->update([
                "content" => $request->data["content"],
            ]);

            $comment =  Comment::find($request->comment_id)->first();
        } catch (\Throwable $th) {
            $message = "Error updating comment $request->comment_id: \n TheError $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $comment);
    }

    public function delete(Request $request)
    {

        $message = "comment with id:$request->comment_id has been deleted successfully";
        $status = true;
        $comment = null;


        try {
            $comment =  Comment::find($request->comment_id);

            if (!$comment) {
                $message = "There are not comment with id:$request->comment_id";
                $status = false;
                return $this->returnForm($message, $status, $comment);
            }
            Comment::find($request->comment_id)->delete();
        } catch (\Throwable $th) {
            $message = "Error deleted comment $request->comment_id: \n TheError $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $comment);
    }

    /// =========================================== Local Functions =============================================
    public function deleteWithPostDelete($post_id)
    {
        $comments = Comment::where("post_id", $post_id)->get();
        foreach ($comments as $comment)
            $comment->delete();
    }
}
