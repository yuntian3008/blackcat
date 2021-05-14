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
    public function handle($request, Closure $next, $permission = '')
    {
        /**
        *   Check isAdmin
        *
        */
        if (! $request->user()->isAdmin) {
            return response()->json('You are not admin',401);
        }


        /**
        *   Check Permission
        *
        */


        // "*" block all and only superadmin can access
        if ($permission == '*') {
            // isn't superadmin OR isn't user->isAdmin
            if (! $request->user()->hasPermission('superadmin')) {
                return response()->json('You don\'t have permission to access.',401);
            }
            return $next($request);
        }
        // "" allow all can accesss
        if ($permission == '')
            return $next($request);


        // "[permission]" can access or Superadmin can access
        if (! $request->user()->hasPermission($permission) && ! $request->user()->hasPermission('superadmin')  ) {
            return response()->json('You don\'t have ['.$permission.'] permission to access.',401);
        }
        return $next($request);
    }
}