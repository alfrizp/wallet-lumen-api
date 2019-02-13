<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;

class JwtMiddleware
{
    use ApiResponser;

    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token') ?: $request->header('api_token');

        if (!$token) {
            throw new AuthenticationException();
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return $this->errorResponse('Provided token is expired', 400);
        } catch (Exception $e) {
            return $this->errorResponse('Invalid token', 400);
        }

        $user = User::find($credentials->sub);

        $request->user = $user;

        return $next($request);
    }
}
