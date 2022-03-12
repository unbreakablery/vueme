<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Route;

class EnsurePhoneIsVerified
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
        $path = $request->path();
        if($request->user() && (!$request->user()->hasVerifiedPhone() || ($request->user()->userProfile()->first()->license_checked == false && $request->user()->role_id == WhiteLabel::config('user')->roles['Model']))){
            if($request->user()->userProfile()->first()->license_checked || $request->user()->role_id != WhiteLabel::config('user')->roles['Model'])
                    return redirect()->route('phone_verification');
                else if($path !== "/")
                    return redirect("/");
        }


        return $next($request);
    }
}
