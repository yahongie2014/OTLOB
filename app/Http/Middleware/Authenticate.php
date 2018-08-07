<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->guest()) {


            if ($request->ajax()) {
                return response('Unauthorized.', 401)->with('danger', "password not correct");

            } else {
                return redirect()->guest('login')/*->with('message', "you are logout")*/;
            }


        }
        if(\Session::get('locked') === true)
            return redirect('/admin/lock')
                ->with('danger', "you are locked");

        return $next($request);
    }
}
