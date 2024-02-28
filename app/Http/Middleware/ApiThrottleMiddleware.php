<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ApiThrottleMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ipAddress  = $request->ip();
        
        $rateLimiter = app(RateLimiter::class);
        $key = 'rate_limit_'.$ipAddress;
        $maxAttempts=1; $decayMinutes=1;

        if(!$rateLimiter->tooManyAttempts($key,$maxAttempts)){
            $rateLimiter->hit($key,$decayMinutes);
            return $next($request);
        }
        return $next($request);
    }
}
