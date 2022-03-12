<?php

namespace App\Listeners;

use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $agent = new Agent();

        $browser = $agent->browser();

        $device = 'Desktop';
        if($agent->isPhone())
         $device = 'Mobile';
        else if($agent->isTablet())
         $device = 'Tablet'; 

         if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
           $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
         }elseif (isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])){
           $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
         }

        $user = Auth::user();
        $user->last_log_in = new \DateTime();
        $user->online = 1;
        if($user->hasVerifiedPhone())$user->login_counter += 1;               
        $user->save();
        UserDevice::updateOrCreate(
            ['user_id' => $user->id],
            [
                'ip' => $_SERVER['REMOTE_ADDR'],
                'browser' => $browser . ' '. $agent->version($browser),
                'system' => $agent->platform(),
                'device' => $device,
                'device_name' => $agent->device()    
            ]
        );
    }
}
