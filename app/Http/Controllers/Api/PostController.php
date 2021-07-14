<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tage;
use App\Http\Api\Controllers\TageController;

use App\Http\Traits\GeneralTraits;
use App\Models\PostTages;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //
    use GeneralTraits;
    // use TageController;




    public function index(Request $request)
    {

        $posts = [];


        $message = 'posts belong have been brought successfully';
        $status = true;


        if ($request->userID != null)
            $posts = $this->get_by_userID($request->userID);
        else if ($request->tage != null)
            $posts = $this->get_by_tage($request->tage);
        else if ($request->search != null)
            $posts = $this->get_by_search($request->search);
        else
            $posts = Post::orderBy('updated_at', "DESC")->with("user:id,name,userName,profliePicture")->with("tages")->get();



        return $this->returnForm($message, $status, $posts);
    }





    public function create(Request $request)
    {

        $message = "post published successfully";
        $status = true;
        $post = null;



        try {
            $post = Post::create([
                "imageUrl" => $request->data["imageUrl"],
                "title" => $request->data["title"],
                "format" => $request->data["format"],
                "comment" => $request->data["comment"],
                "user_id" => app('App\Http\Controllers\Api\UserController')->getUserID($request->userID),
            ]);



            $allTages = [];
            foreach ($request->data["tages"] as $postTage) {
                $tage =  app('App\Http\Controllers\Api\TageController')->addNewTageFromNewPost($postTage);

                $returnPostTage = PostTages::create(["tage_id" => $tage->id, "post_id" => $post->id]);

                array_push($allTages, $returnPostTage);
            }

            $post->tages = $allTages;
        } catch (\Throwable $th) {
            $message  = "creating post LocoalError: $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $post);
    }


    public function update(Request $request)
    {

        $message = "post with id:$request->post_id has been updated successfully";
        $status = true;
        $post = null;


        try {
            $post =  Post::find($request->post_id);


            if ((!$request->data["comment"] && !$request->data["title"])) {
                $message = "nothing to update at post with id:$request->post_id";
                $status = false;
                return $this->returnForm($message, $status, $post);
            }

            if (!$post) {
                $message = "There are no post with id:$request->post_id";
                $status = false;
                return $this->returnForm($message, $status, $post);
            }

            if ($request->data["title"])
                DB::table('posts')->where("id", $request->post_id)->update(
                    [
                        "title" => $request->data["title"],
                    ]
                );
            if ($request->data["comment"])
                DB::table('posts')->where("id", $request->post_id)->update(
                    [
                        "comment" => $request->data["comment"],
                    ]
                );


            $post =  Post::find($request->post_id)->first();
        } catch (\Throwable $th) {
            $message = "Error updated post $request->post_id: \n TheError $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $post);
    }


    public function delete($post_id)
    {

        $message = "post with id:$post_id has been deleted successfully";
        $status = true;
        $post = null;


        try {
            $post =  Post::where("id", $post_id)->first();

            if (!$post) {
                $message = "There are not post with id:$post_id";
                $status = false;
                return $this->returnForm($message, $status, $post);
            }
            $post->delete();
            app('App\Http\Controllers\Api\CommentController')->deleteWithPostDelete($post_id);
            app('App\Http\Controllers\Api\LikeController')->deleteWithPostDelete($post_id);
            app('App\Http\Controllers\Api\ViewController')->deleteWithPostDelete($post_id);
        } catch (\Throwable $th) {
            $message = "Error deleted post $post_id: \n TheError $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $post);
    }





    // ======================================= [Local functions] =======================================
    /// [1] =======



    /// [2] =======
    private function get_by_search($key_word)
    {

        $posts = [];

        $posts = $this->get_by_tage($key_word);

        $posts_by_title = Post::where('title', 'like', "%$key_word%")->orderBy('updated_at', "DESC")->with("tages")->with("user:id,name,userName,profliePicture")
            ->get() ?? [];

        $posts_by_comments = Post::where('comment', 'like', "%$key_word%")->orderBy('updated_at', "DESC")->with("tages")->with("user:id,name,userName,profliePicture")
            ->get() ?? [];



        $posts = array_merge($posts_by_comments->toArray(), $posts_by_title->toArray());




        return array_unique($posts, SORT_REGULAR);
    }



    public function get_by_tage($tage)
    {
        $message = 'post belong to tage:$tage have been brought successfully';
        $status = true;

        $tages = [];

        $tages =  Tage::where("name", $tage)->with("posts")->first();

        if (!$tages)
            return [];

        foreach ($tages->posts as $post)
            $posts = Post::where("id", $post->id)->with("tages")->get();

        return $posts;
    }

    public function get_by_userID($userID)
    {
        $message = 'post belong to tage:$tage have been brought successfully';
        $status = true;


        $posts = Post::where("userID", $userID)->with("tages")->with("user:id,name,userName,profliePicture")->get();

        return $posts;
    }
}
