<?php


namespace App\Http\Traits;

trait GeneralTraits
{



    // public function failerForm($message)
    // {
    //     return response()->json(
    //         [
    //             "message" => $message,
    //             "success" => false
    //         ]
    //     );
    // }


    public function responseForm($message,  $success, $data)
    {
        return response()->json(
            [
                "message" => $message,
                "data" => $data,
                "success" => $success
            ]
        );
    }
}
