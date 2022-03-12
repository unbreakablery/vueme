<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

use Exception;
use Illuminate\Support\Facades\DB;
use Log;

use App\Services\ChatRoomUtils;

use App\Models\Appointment;
use App\Models\model_chat_room;
use App\Models\user_1_1_chat_request;

class cron_cancel_appointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron_cancel_appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel appointments in the past';

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
        $appointments=Appointment::where(function ($query) {
            $query->where('status', '=', "Confirmed");
            $query->orWhere('status', '=', "Pending");
        })->get();

        foreach ($appointments as $appoint) {
            
            $toTimezone=$appoint->user->userProfile->timezone;

            $now=new \DateTime( date('Y-m-d H:i:s', strtotime('-10 minutes')) );
                $now->setTimezone(new \DateTimeZone($toTimezone));

            echo $now->format('Y-m-d H:i:s');
            echo PHP_EOL;

            $records_updated=DB::table('appointment')
                ->where('id', '=', $appoint->id)
                ->where('end_hour', '<', $now->format('Y-m-d H:i:s'))
                ->update(['status' => "Cancelled"]);

            echo $records_updated;
            echo PHP_EOL;

            if ($records_updated) {
                $vchat_request=user_1_1_chat_request::where('appointment_id', '=', $appoint->id)->first();
                 
                if ($vchat_request) {
                    $return_cancel=$vchat_request->cancel();
                }

            }
        }

    }
}
