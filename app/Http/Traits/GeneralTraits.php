<?php


namespace App\Http\Traits;

trait GeneralTraits
{



    public function failerForm($message)
    {
        return response()->json(
            [
                "message" => $message,
                "status" => false
            ]
        );
    }


    public function returnForm($message,  $status, $data)
    {
        return response()->json(
            [
                "message" => $message,
                "data" => $data,
                "status" => $status
            ]
        );
    }
}
