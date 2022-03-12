<?php

namespace App\Http\Middleware;

use Closure;

class SpecialistOffline
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
       
            $user =auth()->user(); 
           
            if($user && $user->role_id == 1 && $user->is_streaming_live){
                $user->is_streaming_live = false;
                $user->appointment_live = null;
                $user->save();
                //Send notification specialist go offline
            }       
        return $next($request);
    }
}
