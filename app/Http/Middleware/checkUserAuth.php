<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Traits\GeneralTraits;


class checkUserAuth
{
    use GeneralTraits;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {  
        if(User::where("userID", $request->header('user_id'))->first())
        return $next($request);
        else
        return redirect()->route("RoleAuthorization");
    }
}
