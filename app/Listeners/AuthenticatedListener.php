<?php

namespace App\Listeners;

use App\Models\UserDevice;
use Jenssegers\Agent\Agent;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;

class AuthenticatedListener
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
        $user = Auth::user();

        if (!$user->online || $user->last_log_in < now()->subDays(1)) {

            $agent = new Agent();

            $browser = $agent->browser();

            $device = 'Desktop';
            if ($agent->isPhone()) {
                $device = 'Mobile';
            } else if ($agent->isTablet()) {
                $device = 'Tablet';
            }

            if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
            } elseif (isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])) {
                $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
            }

            
            $user->last_log_in = new \DateTime();
            if($user->role_id == WhiteLabel::roleId('Model'))
             $user->online = 1;
            $user->save();
            UserDevice::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'browser' => $browser . ' ' . $agent->version($browser),
                    'system' => $agent->platform(),
                    'device' => $device,
                    'device_name' => $agent->device(),
                ]
            );
        }

    }
}
