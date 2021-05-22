<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        /**
        *   Check isAdmin
        *
        */
        // if (! $request->user()->isAdmin) {
        //     return response()->json('You are not admin',401);
        // }


        /**
        *   Check Permission
        *
        */


        // empty roles block all and only superadmin can access
        if (empty($roles)) {
            if (! $request->user()->hasRole('superadmin')) {
                return response()->json('You don\'t have permission to access.',401);
            }
            return $next($request);
        }

        
        if (! $request->user()->hasAnyRole($roles) && ! $request->user()->hasRole('superadmin')  ) {
            return response()->json('You don\'t have permission to access.',401);
        }
        
        return $next($request);
    }
}