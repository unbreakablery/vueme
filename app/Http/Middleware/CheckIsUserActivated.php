<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\ApiUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckIsUserActivated
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

        if (auth()->check() && !auth()->user()->email_validated) {
            Auth::logout();
            return redirect('/');

        }
        return $next($request);
    }
}
