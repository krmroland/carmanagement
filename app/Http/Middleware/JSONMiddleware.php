<?php

namespace App\Http\Middleware;

use Closure;

class JSONMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        // ensure all our requests have the accepts of application/json since this is entirely an API
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
