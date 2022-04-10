<?php

namespace App\Http\Controllers\Api;

use App\Models\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    //

    use GeneralTraits;

    public function index()
    {
        $message = "All view for the post have been brought successfully";
        $success = true;


        try {
            $views = View::all();
        } catch (\Throwable $th) {
            $message = "getting all views error: $th";
            $success = false;
        }


        return $this->responseForm($message, $success, $views);
    }

    public function create(Request $request)
    {

        $message = "view have been published successfully";
        $success = true;
        $view = null;




        try {
            $view = View::create([
                "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->header('user_id')),
                "post_id" => $request->post_id
            ]);
        } catch (\Throwable $th) {
            $message = "View creating error: $th";
            $success = false;
        }

        return $this->responseForm($message, $success, $view);
    }




    /// =========================================== Local Functions =============================================
    public function deleteWithPostDelete($post_id)
    {
        $views = View::where("post_id", $post_id)->get();
        foreach ($views as $view)
            $view->delete();
    }
}
