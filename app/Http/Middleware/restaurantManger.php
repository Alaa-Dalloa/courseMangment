<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class restaurantManger
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
        if(auth()->user()->hasRole('restaurent_manger')){
        return $next($request);
        }
        return response()->json("UnAuthorization" , 403);
    }
}
