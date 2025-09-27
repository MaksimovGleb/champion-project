<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckJwtTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $decodedToken = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        // Токен валиден. Можно продолжить выполнение запроса.
        return $next($request);
    }
}
