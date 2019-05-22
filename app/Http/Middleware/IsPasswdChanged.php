<?php

namespace App\Http\Middleware;

use Closure;

class IsPasswdChanged
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
        if ($request->user() && $request->user()->password_inicial == 0) {
            return $next($request);
        }

        return redirect()->route('password')->with('success', 'Por favor altere a sua password');
    }
}
