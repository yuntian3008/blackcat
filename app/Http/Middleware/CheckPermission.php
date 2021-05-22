<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param String $role [From ROUTE]
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {

        /**
        *   Check Permission
        *
        */


        // "*" block all and only superadmin can access
        if (empty($roles)) {
            // isn't superadmin OR isn't user->isAdmin
            if (! $request->user()->hasRole('superadmin')) {
                return abort(401, 'You don\'t have permission to access.');
            }
            return $next($request);
        }

        //var_dump( $request->user()->hasRole('superadmin') );
        // "[permission]" can access or Superadmin can access
        if (! $request->user()->hasAnyRole($roles) && ! $request->user()->hasRole('superadmin')  ) {
            return abort(401, 'You don\'t have permission to access.');
        }
        return $next($request);
    }
}
