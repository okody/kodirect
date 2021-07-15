<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use App\Models\User;
use App\Models\UserStatus;
use App\Models\UserTokens;
//use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    //

    use GeneralTraits;
    //   use User;

    public function index()
    {

        $message = "all users have been brought successfluy";
        $status = true;

        try {
            $users = User::all();
        } catch (\Throwable $th) {
            //throw $th;
            $message = "error: $th";
            $status = false;
        }

        return $this->returnForm($message, $status, $users);
    }

    public function create(Request $request)
    {

        $message = "The user was added to database without any error";
        $status = true;

        try {
            $user = User::create([
                "email" => $request->info["email"],
                "userName" => $request->info["userName"],
                "userID" => $request->info["userID"],
                "name" => $request->info["name"],

            ]);

            $allTokens = [];
            foreach ($request->info["tokens"] as $token) {
                $dbToken =  UserTokens::create(
                    [

                        "platform" => $token["platform"],
                        "token" => $token["token"],
                        "user_id" => $user->id
                    ]
                );


                array_push($allTokens, $dbToken);
            }

            $userStatus = UserStatus::create(
                [
                    "id" => $user->id,
                    "isActive" => $request->info["status"]["isActive"],
                    "state" => $request->info["status"]["state"],
                    "user_id" => $user->id
                ]
            );
        } catch (\Throwable $th) {
            $message  = "$th";

            $status = false;
        }

        $user["status"] = $userStatus;
        $user["tokens"] = $allTokens;


        return $this->returnForm($message, $status, $user);
    }

    public function update_UserID(Request $request)
    {
        $message = "the userID has been assgin successfully";
        $status = true;

        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function get_user($userID)
    {

        $message = "user with id:$userID found succuflly";
        $status = true;

        try {

            $user =  User::where("userID", $userID)->with("status")->with("tokens")->first();
            if (!$user) {
                $status = false;
                $message = "sorry , no user with id:$userID";
            }
        } catch (\Throwable $th) {
            $message = "error: $th";
            $status = false;
        }


        return $this->returnForm($message, $status, $user);
    }




    // =============================================================================================
    public function getUserID($userID)
    {
        return User::where("userID", $userID)->first()->id;
    }
}
