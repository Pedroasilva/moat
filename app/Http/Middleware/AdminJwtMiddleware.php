<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AdminJwtMiddleware
{
	public function handle($request, Closure $next, $guard = null)
	{
        $headers = array('WWW-Authenticate' => 'Bearer');
        
		if(!$request->hasHeader('Authorization')) {
			// return response()->json([
			// 	'error' => 'Authorization Header not found',
			// 	'WWW-Authenticate' => 'Bearer'
			// ], 401, $headers);
			return redirect(route('admin.home'));
		}

		$token = $request->bearerToken();

		try {
			$credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
		} catch(ExpiredException $e) {
			return redirect(route('login'));
		} catch(Exception $e) {
			return redirect(route('login'));
		}

		$user = User::find($credentials->sub);

		// Now let's put the user in the request class so that you can grab it from there
		$request->auth = $user;

		return $next($request);
	}
}