<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotLoggedInWithGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = null)
    {
       if (Auth::guard($guard)->guest()) {
            if ($guard === 'technician') {
                return redirect()->guest(route('technician.login.index'))->with('url.intended', $request->fullUrl());
            }
        }


        return $next($request);
    }
}
