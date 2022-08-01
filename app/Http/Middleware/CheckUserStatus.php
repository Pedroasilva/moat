<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\User;
use Firebase\JWT\JWT;

class CheckUserStatus
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
        $token = $request->bearerToken();
        $decoded = JWT::decode($token, env('JWT_SECRET'), array('HS256'));
        $user = User::find($decoded->sub);
        if (!$user || !$user->status) {
			return response()->json([
                'error' => 'Acesso não autorizado'
			], 401);
        }
        
		return $next($request);
    }
}
