<?php

namespace App\Http\Middleware;

use Closure;

class ApiGuestMiddleware
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
	    if (!$request->session()->has('user.id') || !$request->session()->has('user.token')) {
		    return $next($request);
	    }
	    return redirect('/');
    }
}
