<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\User;
use Firebase\JWT\JWT;

class CheckRoleApi
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
        $headers = array('WWW-Authenticate' => 'Bearer');
        $token = $request->bearerToken();
		try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(Exception $e) {
			return response()->json([
				'error' => 'An error while decoding token.',
            	'WWW-Authenticate' => 'Bearer'
			], 401, $headers);
        }
        $user = User::find($credentials->sub);
        if (!$user || !$user->isAdministrator()) {
            return response()->json([
                'error' => 'Não autorizado'
            ], 401, $headers);
        }
		return $next($request);
    }
}
