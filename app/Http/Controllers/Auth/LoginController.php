<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhiteLabel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::where('email', '=', $request->email)->first();

        if ($user && $user['account_status'] == 'ADMIN_DISABLED') {
            throw ValidationException::withMessages([
                'password' => 'Your account is disabled. Please contact support@collide.com for assistance',
            ]);
        }

        if ($user && !$user->email_validated) {
            throw ValidationException::withMessages([
                'password' => 'Inactive Login - please contact support@psychics1on.com for assistance.',
            ]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function redirectTo()
    {
        $role = Auth::user()->role_id;
        $redirect = session('redirect');

        if (!is_null($redirect) && !empty($redirect)) {
            return $redirect;
        }

        switch ($role) {
            case WhiteLabel::roleId('Model'):
                return '/dashboard';
                break;
            case WhiteLabel::roleId('User'):
                return '/';
                break;
            case WhiteLabel::roleId('Admin'):
                return '/admin';
                break;
            case WhiteLabel::roleId('Support'):
                return '/admin';
                break;
                
            case WhiteLabel::roleId('Agency'):
                return '/admin';
                break;
            case WhiteLabel::roleId('Horoscope'):
                return '/admin';
                break;
            case WhiteLabel::roleId('Blog'):
                return '/agency';//change-agency
                break;    
            default:
                return '/login';
                break;
        }
    }
}
