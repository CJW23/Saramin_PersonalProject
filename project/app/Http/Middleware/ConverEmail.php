<?php

namespace App\Http\Middleware;

use App\Logic\EncryptionModule;
use Closure;

class ConverEmail
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
        $email = $request->input('email');
        $request->merge(['email' => $email]);
        return $next($request);
    }
}
