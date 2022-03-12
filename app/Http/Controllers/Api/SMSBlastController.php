<?php

namespace App\Http\Controllers\Api;

use App\Models\chat_in;
// use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Country_all;
use App\Services\ApiUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\LogSms;
use function Couchbase\defaultDecoder;

class SMSBlastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verifield');
        $this->middleware('verifyphone');
    }

    public function sendSmsMarketing()
    {
        $html = "INI";
        $campaign_id = 4;
        $users_actives = User::distinct()->select('user_mobile_num.prefix', 'user_mobile_num.code2', 'user_mobile_num.number', 'user.id')
        ->join('user_mobile_num', 'user.id', '=', DB::raw('user_mobile_num.user_id AND user.email_validated = 1 AND user.role_id = 2 AND user.account_status = "ACTIVE"'))
        ->leftJoin('log_sms', 'user.id', '=', DB::raw('log_sms.id_user AND log_sms.campaign_id = '.$campaign_id))
        ->whereNull('log_sms.id_user')
        ->take(300)
        ->get();
        $sent = 0;
        $users_sent = LogSms::where(['campaign_id'=>$campaign_id])->get();
        $num_sent = count($users_sent);
        foreach ($users_actives as $user) {
            $number = $user->user_mobile_nums()->first();
            $message = $user->user_profile->name.", holding up ok? With Respectfully, comfort is a click away. Get answers, support and heal. Talk to your Model now: respectfully.com";
            // $message = "How do you feel in this moment? It’s ok to be scared or confused, you’re not alone. Find your calm, get answers. Talk to your Model now: respectfully.com";
             //$html .= "<BR>".$user->user_profile->name." ".$number['number']." ".$number['prefix']." ".$number['code2'] ;
             
            $desti = (object) array('number' => $number['number'], 'prefix'=>$number['prefix'],'code2'=>$number['code2']);
            TwilioUtils::send_SMS($desti, $message);
            //DB::table('users')->where('name', 'John')->first();
            $date = date('Y-m-d');
            $p= LogSms::insert(['id_user'=>$user->id, 'phone'=>$number['number'], 'message'=>$message,'campaign_id'=>$campaign_id, 'date_message'=>$date]);
            $sent++;
        }
        $html = "Was sent ".$sent." SMS, Total sent campaign: ".$num_sent;
        return $html;
    }
}
