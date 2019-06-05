<?php

namespace App\Http\Middleware;

use Closure;

class VerificarContrasena
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
        if (auth('admin')->user() && auth('admin')->user()->primerContrasena === NULL) {
            return redirect()->route('admin.contrasena');
        } elseif (auth()->user() && auth()->user()->primerContrasena === NULL) {
            return redirect()->route('semana.index');
        }
        return $next($request);
    }
}
