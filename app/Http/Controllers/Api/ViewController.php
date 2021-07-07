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
        $status = true;


        try {
            $views = View::all();
        } catch (\Throwable $th) {
            $message = "getting all views error: $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $views);
    }

    public function create(Request $request)
    {

        $message = "view have been published successfully";
        $status = true;
        $view = null;


        try {
            $view = View::create([
                "user_id" =>  app('App\Http\Controllers\Api\UserController')->getUserID($request->userID),
                "post_id" => $request->post_id
            ]);
        } catch (\Throwable $th) {
            $message = "View creating error: $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $view);
    }




    /// =========================================== Local Functions =============================================
    public function deleteWithPostDelete($post_id)
    {
        $views = View::where("post_id", $post_id)->get();
        foreach ($views as $view)
            $view->delete();
    }
}
