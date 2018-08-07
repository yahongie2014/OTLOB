<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;

use Exception;

class authJWT

{

public function handle($request, Closure $next)

{

try {

$user = JWTAuth::toUser($request->input('token'));


} catch (Exception $e) {

if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

return response()->json(['error'=> trans('api.invalid_token')], 400);

}else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

return response()->json(['error'=> trans('api.token_is_expired')], 400);

}else{

return response()->json(['error' => 1, 'message'=> trans('api.something_is_wrong')], 400);

}

}

return $next($request);

}

}