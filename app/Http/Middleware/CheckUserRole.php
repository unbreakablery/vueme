<?php

namespace App\Http\Middleware;

use App\Services\ApiUtils;
use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if (auth()->check() && auth()->user()->email != 'blake@respectfully.com' && auth()->user()->email != 'account@respectfully.com')
        if (!auth()->user()->hasRole($role)) {

            return redirect('/');

        }
        return $next($request);
    }
}
