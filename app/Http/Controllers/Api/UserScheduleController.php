<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Services\ApiUtils;

use App\Models\User;
use App\Models\UserSchedule;

use Illuminate\Support\Facades\DB;

class UserScheduleController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->middleware('verifield');
        $this->auth = $auth;
    }

    public function get() {
        $user_schedule=Auth::user()->userSchedule;

        $u_s=[];

        foreach ($user_schedule as $details) {
            $u_s[ $details->day ]=$details;
        }


        $concated=DB::select('
            SELECT (GROUP_CONCAT(day)) as `days`, `from`, `till` 
            FROM `user_schedule` 
            WHERE active = 1 and user_id = ?
            GROUP BY `from`,`till` 
        ', [Auth::user()->id]);

        return response()->json(
            [
                'success' => [
                    'user_id' => Auth::user()->id,
                    'user_schedule' => $u_s,
                    'concated' => $concated,
                    'timezone' => Auth::user()->userProfile->timezone
                ]
            ],
            200
        );

    }

    public function save(Request $request) {
        
        foreach ($request->get('user_schedule') as $u_s) {
            if (! $u_s['active']) {
                unset($u_s['from']);
                unset($u_s['till']);
            }
        }

        $request->validate([
            'user_id' => 'required',
            'timezone' => 'required',

            'user_schedule' => 'array',
            'user_schedule.*.active' => 'boolean',
            
            'user_schedule.*.from' => ['sometimes', 'required_if:user_schedule.*.active,1', 'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/'],
            'user_schedule.*.till'=> ['sometimes',  'required_if:user_schedule.*.active,1', 'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/','after_or_equal:user_schedule.*.from'],
        ]);

        
        $user_profile=Auth::user()->userProfile;

        $user_profile->timezone=$request->get('timezone');

        $user_profile->save();


        $posted_schedule = $request->get('user_schedule');

        foreach ($posted_schedule as $day => $details) {

            $schedule_to_save=UserSchedule::updateOrCreate(
                [
                    'user_id' => $request->get('user_id'),
                    'day' => $day
                ],
                $details
            );

        }
        
        $user_schedule=Auth::user()->userSchedule;

        $u_s=[];

        foreach ($user_schedule as $details) {
            $u_s[ $details->day ]=$details;
        }

        return ApiUtils::response_success([ 'user_id' => Auth::user()->id, 'user_schedule' => $u_s ]);

    }

}
