<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if( Auth::user()->is_admin  == 1 ){
                return redirect('/admin');
            }elseif(Auth::user()->is_vendor  == 1 ){
                return redirect('/vendors');
            }elseif(Auth::user()->is_privillage  == 1){
                return redirect('/accountant');

            }elseif(Auth::user()->is_privillage  == 2){
                return redirect('/sales');

            }elseif(Auth::user()->is_privillage  == 3){
                return redirect('/cooker');
            }
        }
        return $next($request);
    }
}
