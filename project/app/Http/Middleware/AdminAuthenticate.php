<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //게스트
        if(!auth()->user())
        {
            return redirect('/login');
        }

        $notAdmin = 0;
        //관리인이 아닌 유저
        if(auth()->user()->admin == $notAdmin)
        {
            return redirect('/');
        }
        return $next($request);
    }
}
