<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->is('admin/login') && Auth::guard('web')->check()) 
            Auth::guard('web')->logout();
        if ($request->is('login') && Auth::guard('admin')->check()) 
            Auth::guard('admin')->logout();


        if (Auth::guard('admin')->check()) {
            return redirect('/admin');
        }

        if (Auth::guard('web')->check()) {
            return redirect('/customer/home');
        }

        return $next($request);
    }
}
