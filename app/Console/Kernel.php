<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\HoroscopeAdminConfig;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\cron_payout_record_process',
		'App\Console\Commands\cron_1_1_vchat_process',
        'App\Console\Commands\cron_cancel_appointments',
        'App\Console\Commands\MakeVideoChatRequestForAppointment' ,
        'App\Console\Commands\refundMessagesWithoutAnswered',        
        'App\Console\Commands\spanishPsychicsNotification',
        'App\Console\Commands\cron_send_notify_first_message_free',
        'App\Console\Commands\SetUserFiveRating',
        'App\Console\Commands\FirstPurchaseCredits',
        'App\Console\Commands\PurchaseCredits',
        'App\Console\Commands\NoLogged30Days',
        'App\Console\Commands\WeeklyHoroscopeManual',
        'App\Console\Commands\WeeklyHoroscopeSignEmail',
        'App\Console\Commands\Specialties30Days',
        'App\Console\Commands\Day10ClientEmail',
        'App\Console\Commands\Day20ClientEmail',
        'App\Console\Commands\Day45ClientEmail',
        'App\Console\Commands\SendPsychicsFeature',
        'App\Console\Commands\UserTopRatePsychics',
        'App\Console\Commands\Day14TipstoGrowPsychic',
        'App\Console\Commands\Day7SuccessPsychic',
        'App\Console\Commands\AfterRegister24Hour',
        'App\Console\Commands\phoneVerification24Hours',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		
        
		
        $schedule->command('email:daily_report')->dailyAt('23:30');
        $schedule->command('cron_payout_record_process')
                 ->weekly()
                 ->mondays()
                 ->at('06:00')
                 ->appendOutputTo('storage/logs/payout/created-('.date('Y-m-d').').log');
        $schedule->command('cron_1_1_vchat:process')->cron('* * * * *')
        ->appendOutputTo('storage/logs/vchatProcess/created-('.date('Y-m-d').').log');

        $schedule->command('MakeVideoChatRequestForAppointments:Run')->cron('* * * * *');

        $schedule->command('cron_cancel_appointments')->cron('* * * * *');
        $schedule->command('command:refund_messages_without_answered')->everyFiveMinutes()
        ->appendOutputTo('storage/logs/refunds/refunds-('.date('Y-m-d').').log');
        $schedule->command('command:cron_send_notify_first_message_free')->dailyAt('12:00')->timezone('America/New_York')
        ->appendOutputTo('storage/logs/firstMessageFree.log');
        $schedule->command('user_five_rating')->hourly();
        $schedule->command('email:no_logged_in_30_day')->daily();
        $schedule->command('email:purchase_credits_1')->daily();
        $schedule->command('email:purchase_credits_2')->daily();
        $schedule->command('email:weekly_hroscope_manual')->weeklyOn(1, '15:00')->timezone('America/New_York');
        $schedule->command('email:weekly_horoscope_sign_email')->weeklyOn(1, '13:00')->timezone('America/New_York');
        $schedule->command('sms:phone_weekly_horoscope_sign')->weeklyOn(1, '13:00')->timezone('America/New_York');
        $schedule->command('email:specialties_30_day')->daily();
        $schedule->command('email:10_day_after_client_register')->daily();
        $schedule->command('email:20_day_after_client_register')->daily();
        $schedule->command('email:45_day_after_client_register')->daily();
        
        $schedule->command('email:14daysTips')->daily();
        $schedule->command('email:7daysSuccess')->daily();
        $schedule->command('email:24_hour_after_register')->daily();
        $schedule->command('sms:24_hour_phone_verification')->daily();



        $schedule->command('email:send_psychics_top_rate')->twiceMonthly(1, 15, '14:00')->timezone('America/New_York');
        $schedule->command('email:send_psychics_feature')->twiceMonthly(7, 28, '14:00')->timezone('America/New_York');



        //test:twice
        $schedule->command('email:test:twice')->twiceMonthly(3, 4, '15:00')->timezone('America/New_York');
        //test:one 
        $schedule->command('email:test:one')->monthlyOn(3, '15:00')->timezone('America/New_York');
        $schedule->command('email:test:one')->monthlyOn(4, '15:00')->timezone('America/New_York');

        
        



        //$schedule->command('email:weekly_hroscope_email')->weeklyOn(3, '13:28')->appendOutputTo('storage/logs/horoscope/weekly_hroscope_email-('.date('Y-m-d').').log'); 
        

        //$schedule->command('spanishPsychicsNotification')->dailyAt('14:12')->appendOutputTo('storage/logs/emails/spanish-email-created-('.date('Y-m-d').').log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
