<?php

namespace App\Http\Middleware;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Closure;

class IsDirecao
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
        if ($request->user() && $request->user()->direcao == 1) {
            return $next($request);
        }

        throw new AccessDeniedHttpException('Unauthorized.');
    }
}
