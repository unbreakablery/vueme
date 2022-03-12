<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;

class Admin
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
        $user = Auth::user();
        
        if($user->role_id == WhiteLabel::roleId('Admin') || $user->role_id == WhiteLabel::roleId('Blog') || $user->role_id == WhiteLabel::roleId('Support') || $user->role_id == WhiteLabel::roleId('Agency') || $user->role_id == WhiteLabel::roleId('Horoscope'))
        return $next($request);

        return redirect()->route('home');
    }
}
