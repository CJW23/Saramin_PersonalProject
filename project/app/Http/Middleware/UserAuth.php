<?php

namespace App\Http\Middleware;

use Closure;

class UserAuth
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
        if(!auth()->user())
        {
            return redirect('/login');
        }

        $notUser = 1;
        if(auth()->user()->admin == $notUser)
        {
            return redirect('/admin');
        }
        return $next($request);
    }
}
