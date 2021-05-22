<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckPhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() ||
            is_null($request->user()->firebase_uid)) {
            return $request->expectsJson()
                    ? abort(403, 'Your phone is not verified.')
                    : Redirect::route($redirectToRoute ?: 'verification.otp');
        }
        return $next($request);
    }
}
