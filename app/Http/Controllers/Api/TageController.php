<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tage;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

class TageController extends Controller
{

    use GeneralTraits;

    public function index()
    {
        $message = "All tages  have been brought successfully";
        $success = true;
        $tages = [];


        try {
            $tages = Tage::with("posts")->get();
            foreach ($tages as $tage) {
                $tage["tage_posts"] =
                    count($tage["posts"]);
                unset($tage["posts"]);
            }
        } catch (\Exception $th) {
            $message = "Error fetching tages: Api/TageController/index  $th";
            $success = false;
        }



        return $this->responseForm($message, $success, $tages);
    }


    



    public function addNewTageFromNewPost($postTage)
    {

        $tage = Tage::where("name", $postTage)->first();

        if (!$tage)
            $tage = Tage::create([
                "name" => $postTage,
            ]);

        return $tage;
    }


    public function getTageIdByName($tage)
    {

        return Tage::where("name", $tage)->first()->id;
    }
}
