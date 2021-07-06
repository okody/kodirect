<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tage;

use Illuminate\Http\Request;

class TageController extends Controller
{

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
