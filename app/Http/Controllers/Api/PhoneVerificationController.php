<?php

namespace App\Http\Controllers\Api;


use App\Services\ApiUtils;
use App\Models\Country_all;
use Illuminate\Http\Request;
use App\Models\UserMobileNum;
use App\Services\TwilioUtils;
use App\Services\WebUtils;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class PhoneVerificationController extends Controller
{


    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->auth = $auth;
    }

    public function addAndVerifyPhoneNumber(Request $request)
    {

        $validator = $request->validate([
            'code2' => 'required',
            'number'  => WebUtils::verifyPhone([(object)['number' => $request->input('number')]]) ? 'required|min:10|numeric|regex:/[0-9]{10}/' : 'required|min:10|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
        ]);

        $user = Auth::user();
        $phoneNumber = $user->user_mobile_nums()->first();

        $prefix  = Country_all::where('code2', $request->input('code2'))->first()->prefix;

        $phoneNumber->code2 = $request->input('code2');
        $phoneNumber->prefix = $prefix;
        $phoneNumber->number = $request->input('number');
        $phoneNumber->save();

        //send sms
        if(!WebUtils::verifyPhone([(object)['number' => $request->input('number')]]))
        $this->sendSms();
        return response()->json(['message'=> 'Verification code sent'], 200);
    }

    public function verifyCode(Request $request)
    {

        $validator = $request->validate([
            'code' => 'required',
        ]);


        $user = Auth::user();
        $phoneNumber = $user->user_mobile_nums()->first();

        if($request->input('code') == $phoneNumber->verification_code)
        {
            $phoneNumber->validated = true;
            $phoneNumber->verification_code = null;
            $phoneNumber->save();
            return response()->json(['message'=> 'Phone verified'], 200);
        }
        else
        {
            return ApiUtils::response_fail(['message'=> 'Invalid verification code'], 400);

        }
    }

    public function validateInvalidate($id)
    {

        $phoneNumber = UserMobileNum::find($id);

        $phoneNumber->validated = !$phoneNumber->validated;
        $phoneNumber->verification_code = null;
        $phoneNumber->save();
        return response()->json(['message'=> 'Phone verified'], 200);
    }

    public function sendSms()
    {

        $user = Auth::user();
        $mobile = $user->user_mobile_nums()->first();

        if($mobile){
            $code = rand(1000, 9999); //generate random code
            $mobile->verification_code = $code; //save code
            $mobile->save();

            TwilioUtils::send_verification_sms($mobile,$user);
            return response()->json(['message'=> 'We have texted a verification code to +'.$mobile->code2.$mobile->number], 200);

        }else{
            return ApiUtils::response_fail(['message'=> 'Phone number unavailable.'], 400);

        }
    }


}
