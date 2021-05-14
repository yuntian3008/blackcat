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
    public function handle($request, Closure $next, $permission = '')
    {
        /**
        *   Check isAdmin
        *
        */
        if (! $request->user()->isAdmin) {
            return abort(401, 'You are not admin!');
        }


        /**
        *   Check Permission
        *
        */


        // "*" block all and only superadmin can access
        if ($permission == '*') {
            // isn't superadmin OR isn't user->isAdmin
            if (! $request->user()->hasPermission('superadmin')) {
                return abort(401, 'You don\'t have permission to access.');
            }
            return $next($request);
        }
        // "" allow all can accesss
        if ($permission == '')
            return $next($request);


        // "[permission]" can access or Superadmin can access
        if (! $request->user()->hasPermission($permission) && ! $request->user()->hasPermission('superadmin')  ) {
            return abort(401, 'You don\'t have ['.$permission.'] permission to access.');
        }
        return $next($request);
    }
}
