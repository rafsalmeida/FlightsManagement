<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class IsOwner
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
        $user_id = $request->route()->parameters();
        dd($user_id);
        if ($request->user() && $request->user()->id === $user_id) {
            return $next($request);
        }

        throw new AccessDeniedHttpException('Unauthorized.');
    }
}
