<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "doctor" && Auth::guard($guard)->check()) {
            $user = json_decode(json_encode(Auth::guard('doctor')->user()),1);
            if($user['is_active'] && $user['is_verified'] && !$user['is_delete']){
                return redirect()->intended('/doctor-dashboard');
            }else if(isset($user['is_active']) && !$user['is_active']){
                Auth::guard('doctor')->logout();
                return redirect()->route('login')
                    ->with('error','Your account is not active');
            }else if(isset($user['is_verified']) && !$user['is_verified']){
                Auth::guard('doctor')->logout();
                return redirect()->route('login')
                    ->with('error','Your account is not verified');
            }else{
                return redirect()->route('login')
                    ->with('error','Invalid Credentials');
            }
        }
        if ($guard == "patient" && Auth::guard($guard)->check()) {
            return redirect('/patient-dashboard');
        }
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
