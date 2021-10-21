<?php

namespace App\Http\Middleware;

use Closure;

class UpdateProfile
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
        if (!$request->user()->firstname || !$request->user()->lastname || !$request->user()->dob) {
            $request->session()->flash('warning', 'Please fill in your personal information');
            return redirect()->route('customer.profile');
        }
        return $next($request);
    }
}
