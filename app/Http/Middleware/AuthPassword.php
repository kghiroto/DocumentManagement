<?php

namespace App\Http\Middleware;

use Closure;

use App\Password;

class AuthPassword
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
        $urlKey = $request->route()->parameter('url_key');
        if (Password::existsPassword($urlKey) == false) {
            abort(404);
        }

        return $next($request);
    }
}
