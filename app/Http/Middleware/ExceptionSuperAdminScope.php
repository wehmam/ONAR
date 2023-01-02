<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExceptionSuperAdminScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(\Sentinel::check()) {
            if(is_null(\Sentinel::check()->company_id)) {
                alertNotify(false, "Permission Denied!");
                return redirect(url("backend"));
            }
        }

        return $next($request);
    }
}
