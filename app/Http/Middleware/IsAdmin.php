<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        $allowed = 'admin';
        if(Auth::user() && Auth::user()->role === $allowed){
            return $next($request);    
        }
        
        return redirect('/');
    }
}
