<?php

namespace App\Http\Middleware;

use App\User;
use App\Models\SubscriptionAddonModel;
use Illuminate\Support\Facades\Auth;
use Session;
use Closure;

class Subscription
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
           if ($user->role != 'admin' && $user->role != 'support' && $user->role != 'reviewer'){
                if($user->is_active == false ){
                    $message = 'You account is inactive please contact support';
                    Session::put('error', $message);
                    return redirect('/logout');
                }

                if(userHasAccessToFrontend($user->id)){
                    $userHasAccessToFrontEnd =  true;
                }else{
                    $userHasAccessToFrontEnd = false;
                }
                

                if(!$userHasAccessToFrontEnd ){
                    $message = 'You don\'t have an active subscription, please contact support';
                    Session::put('error', $message);
                    return redirect('/logout');
                }

            }

        }else{
            return redirect('/logout');
        }
        return $next($request);
    }
}
