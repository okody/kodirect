<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class checkIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {




        if (!$this->isAdmin($request->userID)) {

            return  redirect()->route("RoleAuthorization");
        }


        return $next($request);
    }

    private function isAdmin($userID)
    {



        $user = User::where("userID", $userID)->first();

        if (!$user->role)
            return false;

        return $user->role == "admin" ? true : false;
    }
}
