<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Exception;
use Log;

use App\Services\ChatRoomUtils;

use App\Models\model_chat_room;
use App\Models\user_1_1_chat_request;

class cron_1_1_vchat_process extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron_1_1_vchat:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process current 1-1 video chats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Expire all waiting records over 2hrs old
        $u = new user_1_1_chat_request();
        $u->expireWhenPsychicIsOnline();
        $u->expireAll();

        $star_chat_rooms = model_chat_room::whereIn('state', ['LIVE','WAITING'])
            ->orderBy('created_at', 'ASC')
            ->with('fan_chat_room')
            ->with('user_1_1_chat_request')
            ->get();

        if (!$star_chat_rooms->count()) {
            return;
        }

        foreach ($star_chat_rooms as $star_chat_room) {
            try {
                $result = ChatRoomUtils::process([
                    'model_chat_room' => $star_chat_room,
                ]);
            } catch (Exception $e) {
                Log::warning('cron_1_1_vchat_process fail process() - ' . print_r($star_chat_room->toArray(), true));
                Log::warning($e);
 //               print "Caught exception ".$e->getMessage();
                $result = $star_chat_room->process_end_chat();
                $result = $result[1];
            }
            
         }
    }
}
