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
    }

    public function create(Request $request)
    {

        $message = "The user was added to database without any error";
        $status = true;

        try {
            $user = User::create([
                "email" => $request->data["email"],
                "userName" => $request->data["userName"],
                "userID" => $request->data["userID"],
                "name" => $request->data["name"]
            ]);

            $allTokens = [];
            foreach ($request->data["tokens"] as $token) {
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
                    "isActive" => $request->data["status"]["isActive"],
                    "state" => $request->data["status"]["state"],
                    "user_id" => $user->id
                ]
            );
        } catch (\Throwable $th) {
            $message  = "$th";
            return $th;
            $status = false;
        }

        $user["status"] = $userStatus;
        $user["tokens"] = $allTokens;


        return $this->returnForm($message, $status, $user);
    }

    public function get_user($id)
    {

        $message = "user with id:$id found succuflly";
        $status = true;

        $user =  User::find($id);
        if ($user == null) {
            $status = false;
            $message = "sorry , no user with id:$id";
        }

        $userStatus = UserStatus::find($id);
        $user->status = $userStatus;

        $tokens = UserTokens::where("user_id" , $id);

        return $this->returnForm($message, $status, $tokens);
    }
}
