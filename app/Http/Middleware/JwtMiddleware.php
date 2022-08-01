<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
	public function handle($request, Closure $next, $guard = null)
	{
        $headers = array('WWW-Authenticate' => 'Bearer');

		if(!$request->hasHeader('Authorization')) {
		  return response()->json([
                'error' => 'Authorization Header not found',
                'WWW-Authenticate' => 'Bearer'
			], 401, $headers);
		}

		$token = $request->bearerToken();

		try {
			$credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
		} catch(ExpiredException $e) {
			return response()->json([
                'error' => 'Provided token is expired.',
                'WWW-Authenticate' => 'Bearer'
			], 401, $headers);
		} catch(Exception $e) {
			return response()->json([
				'error' => 'An error while decoding token.',
            	'WWW-Authenticate' => 'Bearer'
			], 401, $headers);
		}

        $user = User::find($credentials->sub);

        // Verifica se o Usuário está ativo
        if ($user->status === false) {
            return response()->json([
                'message' => 'Usuário inativado.',
            ], 401);
        }

        // Verifica se o Token Remember é o mesmo do user no Banco de Dados..
        if (!$credentials->rmb || $user->remember_token !== $credentials->rmb) {
            return response()->json([
                'error' => 'Provided token is expired.',
                'WWW-Authenticate' => 'Bearer'
            ], 401, $headers);
        }

		// Now let's put the user in the request class so that you can grab it from there
		$request->auth = $user;

		return $next($request);
	}
}
