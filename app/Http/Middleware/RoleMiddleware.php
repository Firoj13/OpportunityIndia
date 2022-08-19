<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    public function handle($request, Closure $next, $role="admin", $permission = null)
    {
        /*if(!$request->user()->hasRole($role)) {

             abort(404);

        }*/

        if($permission !== null && !$request->user()->can($permission)) {

              abort(404);
        }

        return $next($request);

    }
    

    /*public function handle($request, Closure $next, $role="admin")
    {
        if(!auth()->guard($role)->check()) {
            return redirect(route('admin.login'));
        }
        return $next($request);
    }*/

}
