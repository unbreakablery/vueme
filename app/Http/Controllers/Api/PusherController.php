<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Pusher\Pusher;

class PusherController extends Controller
{
    public function __construct()
    {     
        $this->middleware('pusher_webhook');       
    }
    public function webhook_live(Request $request){

        foreach ($request()->input('events') as $event) {
            $channelPusher = $event['channel'];
            $user_id = $event['user_id'];
            $name = $event['name'];            
            $event = Pusher::event($channelPusher, $user_id, $name);
    
            if ($event->isValid()) $event->handle();
        }
    
        return response([], 200);
    }
}
