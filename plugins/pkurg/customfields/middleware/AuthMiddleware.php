<?php namespace Pkurg\Customfields\Middleware;

use Closure;
use Pkurg\Customfields\Models\Settings;
use Response;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {

        if ($request->is('api/*')) {
            

            if (!($request->key == Settings::get('apikey'))) {

                return Response::make("Access Denied", 403);

            }

        }
        return $next($request);

    }
}
