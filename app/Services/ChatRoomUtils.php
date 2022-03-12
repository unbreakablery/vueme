<?php namespace App\Services;

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\Role;
use OpenTok\Session;
use OpenTok\Exception;
use OpenTok\Exception\DomainException;
//use WhiteLabel;
use Log;

use GuzzleHttp\Exception\ClientException;


class ChatRoomUtils {

    public $tokbox = [
        'tokbox_api_key'=> '46445262',
        'tokbox_api_secret' => 'fdebd48327499361e1db1665b8b35055e68fa594'
    ];

    static function get_room_id(){
        $utils = new ChatRoomUtils();

        $apiObj = new OpenTok(
            $utils->tokbox['tokbox_api_key']
            ,$utils->tokbox['tokbox_api_secret']
        );

        try {
            $session = $apiObj->createSession();
        } catch (ClientException $e){
            return [false,"Could not create chat room."];
        }
        return [true,$session->getSessionId()];
    }

    static function get_token($session_id,$data=[]){
        $utils = new ChatRoomUtils();

        $apiObj = new OpenTok(
            $utils->tokbox['tokbox_api_key']
            ,$utils->tokbox['tokbox_api_secret']
        );
        $options = json_encode($data);
        if (strlen($options)>1000){
            return [false,"Error creating chat room."];
        }

        try
        {
            $token = $apiObj->generateToken($session_id ,['data' => $options]);
        } catch (ClientException $e) {
            return [false,"Failed to create chat room."];
        }

        return [true,$token];
    }

    // Build these out as part of accounting.

    static function is_room_empty($session_id){
        if (ChatRoomUtils::number_of_streams($session_id)<1){
            return true;
        }
        return false;
    }

    static function number_of_streams($session_id){

        $utils = new ChatRoomUtils();

        $apiObj = new OpenTok(
            $utils->tokbox['tokbox_api_key']
            ,$utils->tokbox['tokbox_api_secret']
        );

        try
        {

            $streams = $apiObj->listStreams($session_id);

            // Log::warning($streams->totalCount());

        } catch (ClientException $e) {
            return 0;
        }

        return $streams->totalCount();

    }

    static function clear_room($session_id,$reason = ""){
        $data = [
            'action'=>'TERMINATE'
        ];

        if ($reason != ""){
            $data['message'] = $reason;
        }

        ChatRoomUtils::send_signal($session_id,$data);

        return true;
    }

    static function send_signal($session_id,$data){

//		Log::debug("Sending signal to $session_id with data = \n\n".print_r($data,true));
        $utils = new ChatRoomUtils();

        $apiObj = new OpenTok(
            $utils->tokbox['tokbox_api_key']
            ,$utils->tokbox['tokbox_api_secret']
        );
        try
        {
            $payload = [
                'type'=>'collide_server'
                ,'data'=>json_encode($data)
            ];
            $signal = $apiObj->signal($session_id,$payload);

        } catch (ClientException $e) {
            return false;
        }

        return true;
    }

    static function process($process_data){
        if (!isset($process_data['model_chat_room'])){
            return false;
        }
        $star_chat_room = $process_data['model_chat_room'];
        $session_id = $star_chat_room->tokbox_session_id;
        $stream_total = ChatRoomUtils::number_of_streams($session_id);

	    //Log::debug("Stream total: $stream_total");

        switch ($stream_total) {
            case 0:
            case 1:
                switch ($star_chat_room->state){
                    case'LIVE':
                        $star_chat_room->process_end_chat();
                        continue;
                    case 'WAITING':
                    default:
                        continue;
                }
                continue;

            case 2:
                switch ($star_chat_room->state){
                    case'WAITING':
//						Log::debug("2 signals and waiting...");
                        $star_chat_room->go_live();
                        $result=$star_chat_room->start_session();
                        if (!$result[0]){
                            ChatRoomUtils::clear_room($star_chat_room->tokbox_session_id,$result[1]);
                            $star_chat_room->process_end_chat();
                        }
                        continue;
                    case 'LIVE':
                        $result=$star_chat_room->live_session_update();
                        if (!$result[0]){
                            ChatRoomUtils::clear_room($star_chat_room->tokbox_session_id,$result[1]);
                            $star_chat_room->process_end_chat();
                        }

                    default:
                        continue;
                }

            default:
        }

        return "Processed Room: ".$session_id;
    }

}
