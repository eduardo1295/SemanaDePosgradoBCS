<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureAdminEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user('admin') || ($request->user('admin') instanceof MustVerifyEmail && !$request->user('admin')->hasVerifiedEmail())) {
            
            if($request->user()){
                if (! $request->user() ||
                ($request->user() instanceof MustVerifyEmail &&
                ! $request->user()->hasVerifiedEmail())) {
                    
                return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : Redirect::route('verification.notice');
                }else {
                    return $next($request);
                }
            }
            return Redirect::route('admin.verification.notice');
        }

        return $next($request);
    }
}
