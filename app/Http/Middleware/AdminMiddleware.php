<?php

namespace App\Http\Middleware;

use Closure, Auth;

class AdminMiddleware
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role != 'admin' && $user->role != 'support'){
                return redirect()->route('login');
            }
        }else{
            return redirect()->route('login');
        }
        return $next($request);
    }
}
