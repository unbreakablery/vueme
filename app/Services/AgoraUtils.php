<?php 

namespace App\Services;

use Exception;
/*use Laravel\Passport\Bridge\User;*/
use Illuminate\Support\Facades\Config;
use Log;
use Response;
use App\Models\User;
use App\Services\WhiteLabel;
use App\Services\Agora\RtcTokenBuilder;
use App\Services\Agora\RtmTokenBuilder;
use DateTime;
use DateTimeZone;

class AgoraUtils {
   
    public static function generate_access_token_agora_rtc($appointment,$user) {
        
        $appID = "0e8db726de66470eb775e0140eff49d4";
        $appCertificate = "4faad3325ce1450b94751957c71cfc8c";
        $channelName = $appointment->channel;
        $uid = $user->id;
        $uidStr = "2882341273";
        $role = $user->role_id == 1 ? RtcTokenBuilder::RolePublisher : RtcTokenBuilder::RoleSubscriber;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        
        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
      
       
        return $token;
    //     $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
    //    return $token;
    }
    public static function generate_access_token_agora_rtm($appointment,$user) {
        
        $appID = "0e8db726de66470eb775e0140eff49d4";
        $appCertificate = "4faad3325ce1450b94751957c71cfc8c"; 
        $channelName = $appointment->channel;     
        $user2 = $user->id;       
        //$role = $user->role_id == 1 ? RtcTokenBuilder::RolePublisher : RtcTokenBuilder::RoleSubscriber;
        $role = RtmTokenBuilder::RoleRtmUser;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
       
        $token = RtmTokenBuilder::buildToken($appID, $appCertificate, (string)$user2, $role, $privilegeExpiredTs);

      
     
        return $token;

    }

}