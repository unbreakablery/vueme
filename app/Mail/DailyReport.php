<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserCreditLog;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyReport extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [];

        // $date2 = new Carbon();

        // $keyDate = $date2->format('m/d/Y');

        // $data[$keyDate] = [];

        // $data[$keyDate]['models'] = User::where('role_id', WhiteLabel::roleId('Model'))
        //     ->where('email_validated', 1)->where('user.fraud', 0)->where('user.test_user', 0)->where('user.account_status', 'ACTIVE')
        //     ->where('user.profile_percent', '!=', 0)
        //     ->whereNotNull('user_profile.cover_path')->whereNotNull('user_profile.haedshot_path')->whereRaw('(user_profile.intro_video_path IS NOT NULL OR user_profile.intro_audio_path IS NOT NULL)')
        //     ->count();

        // $data[$keyDate]['users'] = User::where('role_id', WhiteLabel::roleId('User'))
        //     ->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)->where('account_status', 'ACTIVE')
        //     ->count();

        // $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout;

        // $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);

        // $data[$keyDate]['renueve'] = $numberFormatter->format(UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')->whereBetween('user_credit_log.created_at', [$date2->copy()->startOfDay(), $date2->copy()->endOfDay()])->where('user_credit_log.action', 'BUY_CREDIT')->where('user.email_validated', 1)->where('user.fraud', 0)->where('user.test_user', 0)->sum('user_credit_log.credits'));

        // $data[$keyDate]['refund'] = $numberFormatter->format(UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')->where('user_credit_log.action', 'ACCOUNT_REFUND')->whereBetween('user_credit_log.created_at', [$date2->copy()->startOfDay(), $date2->copy()->endOfDay()])->where('user.email_validated', 1)->where('user.fraud', 0)->where('user.test_user', 0)->sum('user_credit_log.credits'));

        // return $this->markdown("emails.dailyReport")
        //     ->from('support@respectfully.com', 'Respectfully Team')
        //     ->subject("Respectfully | Today's Snapshot")
        //     ->with(['data' => collect($data)->reverse()->toArray()]);

        $date = new Carbon();

        for ($i = 0; $i < 7; $i++) {

            $date2 = $date->copy();
            date_sub($date2, date_interval_create_from_date_string("$i days"));
            $keyDate = $date2->format('m/d/Y');

            $data[$keyDate] = [];

            $data[$keyDate]['models'] = User::join('user_profile', 'user_profile.user_id', '=', 'user.id')->
            where('role_id', WhiteLabel::roleId('Model'))
            ->where('email_validated', 1)->where('user.fraud', 0)->where('user.test_user', 0)->where('user.account_status', 'ACTIVE')
            ->where('user.profile_percent', '!=', 0)
            ->whereNotNull('user_profile.cover_path')->whereNotNull('user_profile.haedshot_path')->whereRaw('(user_profile.intro_video_path IS NOT NULL OR user_profile.intro_audio_path IS NOT NULL)')->where('user.created_at', '<=', $date2->copy()->endOfDay())->count();

            $data[$keyDate]['users'] = User::where('role_id', WhiteLabel::roleId('User'))
                ->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)->where('account_status', 'ACTIVE')->where('user.created_at', '<=', $date2->copy()->endOfDay())
                ->count();

            $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);

            $data[$keyDate]['renueve'] = $numberFormatter->format(UserCreditLog::whereBetween('created_at', [$date2->copy()->startOfDay(), $date2->copy()->endOfDay()])->where('action', 'BUY_CREDIT')->sum('credits'));

            $data[$keyDate]['refund'] = $numberFormatter->format(UserCreditLog::where('action', 'ACCOUNT_REFUND')->whereBetween('created_at', [$date2->copy()->startOfDay(), $date2->copy()->endOfDay()])->sum('credits'));
        }

        return $this->markdown("emails.dailyReport")
        ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject("Respectfully | Today's Snapshot")
            ->with(['data' => $data]);
    }
}
