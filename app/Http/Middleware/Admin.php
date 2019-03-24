<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Admin
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
        if(!Auth::user() || !Auth::user()->is_admin)
            return response()->json(["errors" => ["Unauthorized or not enough privileges!"]], 401);
        return $next($request);
    }
}
