<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsUserSAles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( Auth::user()->is_privillage  != 2 ) {

            return redirect()->guest('login')->with('flag', '1');
        }

        return $next($request);
    }
}
