<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return respose()->json(['msg' => 'Token is Invalid']);
            }
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return respose()->json(['mg' => 'Token has expired']);
            }
            return response()->json(['msg' => 'Authorization Token not found']);
        }
        return $next($request);
    }
}
