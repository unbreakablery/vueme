<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Services\ApiUtils;

use App\Models\User;
use App\Models\UserService;
use App\Models\Services;

class UserServicesController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api')->except('verifyUser');
        $this->middleware('verifield');
        $this->auth = $auth;
    }

    public function get() {
    
        return response()->json(
            [
                'success' => [
                    'services' => Services::all(),
                    'user_id' => Auth::user()->id,
                    'user_services' => Auth::user()->userService,
                    'free_chat' => Auth::user()->chat_free,
                    'browserSupported'=>  Auth::user()->device()->first()->isBrowserSupportedSettings()
                ]
            ],
            200
        );

    }

    public function save(Request $request) {

        $posted_user_services=$request->get('user_services');
        $user = Auth::user();
        $user->chat_free = $request->get('free_chat');
        $services = false;

        
        $request->validate([
            'user_id' => 'required',
            'user_services' => 'array',
            'user_services.*.active' => 'boolean',
            'user_services.0.rate' => 'required|numeric|min:2',
            'user_services.1.rate' => 'required|numeric|min:2',
            //'user_services.2.rate' => 'required_if:user_services.2.active,1|numeric|min:3.75', 
            'user_services.0.min_duration' => 'required|integer|min:5',
            //'user_services.1.min_duration' => 'required|integer|min:5',
        ]);
     
        

        foreach ($posted_user_services as $pus) {
            $services = $services || $pus['active'];
            $us_to_save = UserService::updateOrCreate(
                [
                    'user_id' => $request->get('user_id'), 
                    'service_id' => $pus['service_id']
                ],
                $pus
            );

        }
        if(!$services){
             $user->online = $services;
        }       
        $user->save();

        return ApiUtils::response_success([ 'user_services' => Auth::user()->userService, 'user_online'=>$user->online ]);

    }

}
