<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserWorkSpaceModel;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;

class WhitelabelAccess
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
        if(!userHasAccessToReseller(Auth::id())){
            return redirect()->route('user.dashboard');
        }
        return $next($request);
    }
}
