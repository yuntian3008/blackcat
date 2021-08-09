<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlocked
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
         if (auth()->check() && auth()->user()->block ) {
            $message = 'Your account has been blocked. Please contact administrator.';
            auth()->logout();
            if($request->is('admin') || $request->is('admin/*'))
                return redirect()->route('admin.login')->withMessage($message);
            return redirect()->route('login')->withMessage($message); 
        }
        return $next($request);
    }
}
