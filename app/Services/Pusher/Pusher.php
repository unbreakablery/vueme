<?php

namespace App\Services\Pusher;

use Exception;

class Pusher
{
 
    const events = [
        'member_added' => MemberAdded::class,
        'member_removed' => MemberRemoved::class
    ];   
    public static function event($channelPusher, $user_id, $name){
        foreach (Pusher::events as $key => $class) {
            if ($key == $name) {
                return new $class($channelPusher, $user_id);
            }
        }
    
        throw new Exception('invalid_webhook_event', [$name]);
    }
}