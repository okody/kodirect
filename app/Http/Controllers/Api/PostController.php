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


        $posts = $request->search != null ? $this->get_by_search($request->search) : Post::orderBy('updated_at', "DESC")->with("comments")->with("likes")->with("tages")->with("user")
            ->get();;



        return $this->returnForm($message, $status, $posts);
    }




    public function getByTage($tage, $inner = false)
    {
        $message = 'post belong to tage:$tage have been brought successfully';
        $status = true;

        $tages = [];

        $tages =  Tage::where("name", $tage)->with("posts")->first();

        if ($inner)
            return $tages->posts;

        return $this->returnForm($message, $status, $tages->posts);
    }


    public function create(Request $request)
    {

        $message = "post published successfully";
        $status = true;
        $post = null;



        // try {
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
        // } catch (\Throwable $th) {
        //     $message  = "creating post LocoalError: $th";
        //     $status = false;
        // }


        return $this->returnForm($message, $status, $post);
    }


    // ======================================= [Local functions] =======================================
    /// [1] =======



    /// [2] =======
    private function get_by_search($key_word)
    {

        $posts = [];



        // $posts_by_tages = $this->getByTage($key_word, true);


        $posts_by_title = Post::where('title', 'like', "%$key_word%")->orderBy('updated_at', "DESC")->with("tages")->with("comments")->with("likes")->with("user")
            ->get() ?? [];

        $posts_by_comments = Post::where('comment', 'like', "%$key_word%")->orderBy('updated_at', "DESC")->with("tages")->with("comments")->with("likes")->with("user")
            ->get() ?? [];



        $posts = array_merge($posts_by_comments->toArray(), $posts_by_title->toArray());




        return array_unique($posts, SORT_REGULAR);
    }
}
