<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkApiPassword
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


        if ($request->header('key') != env("apiPassword", "CCIgyp4OYlm2mnjr3oloJU")) {

            return redirect()->route("ApiAuthorization");
        }

        return $next($request);
    }
}
