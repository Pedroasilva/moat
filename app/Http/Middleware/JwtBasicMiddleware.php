<?php

namespace App\Http\Middleware;

use Closure;

class JwtBasicMiddleware
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
        $envs = [
            'local',
            'staging',
            'production'
        ];

        if(in_array(app()->environment(), $envs)) {
            $headers = array('WWW-Authenticate' => 'Basic');

            if (!$request->hasHeader('X-Api-Username') || !$request->hasHeader('X-Api-Password')) {
                return response()->json([
                        'error' => 'Credential Headers not found.',
                        'WWW-Authenticate' => 'Basic'
                    ], 401, $headers);
            }

            $userProvided = $request->header('X-Api-Username');
            $passProvided = $request->header('X-Api-Password');

            if ($userProvided != env('API_USERNAME') || $passProvided != env('API_PASSWORD')) {
                return response()->json([
                        'error' => 'Credential Headers not match.',
                        'WWW-Authenticate' => 'Basic'
                    ], 401, $headers);
            }
        }

        return $next($request);
    }

}