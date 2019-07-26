<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        
        if (auth()->user() && !auth()->user()->hasRoles(['subadmin'])) {
            //dd(!Auth::guard($guard)->check() && auth()->user() && !auth()->user()->hasRoles(['subadmin']));
            return abort(403);
            return redirect('semana');
        }
        
        if (!Auth::guard($guard)->check() && !auth()->user()) {
            //dd(!Auth::guard($guard)->check() && auth()->user() && !auth()->user()->hasRoles(['subadmin']));
            //dd("no es admin");
            return redirect('admin/login');
        }
        
        return $next($request);
    }

}
