<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class IsNotDeleted
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
        if($request->user() && !$request->user()->trashed()){
            return $next($request);
        }

        throw new AccessDeniedHttpException('Unauthorized.');
    }
}
