<?php

namespace App\Http\Middleware;

use Closure;

class CheckStatus
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
        $response = $next($request);
        // if the status is not approved redirect to login 
        if (auth()->check() && auth()->user()->status != 1) {
            auth()->logout();
            return redirect('/login')->with('err_login', 'Your error text');
        }
        return $response;
    }
}
