<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Activation;


class CheckActivatedAdmin
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
            $activation = Activation::where("user_id" , \Sentinel::check()->id)
                ->first();

            if(is_null($activation->completed_at)) {
                // backend/companies/1/edit
                alertNotify(false, "Anda belum melengkapi data profil company");
                return redirect(url("backend/companies/" . \Sentinel::check()->company_id . "/edit"));
            }
            
            return $next($request);
        }
        return redirect("/backend/login");
    }
}
