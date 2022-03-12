<?php
namespace App\Http\Trails;

use App\Models\User;
use App\Models\UserCreditLog;
use App\Services\WhiteLabel;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\v1\PsychicPayoutLogsResourceCollection;
use App\Services\PayoutUtils;



trait PayoutTrail
{
    public function payout(User $user, $earning = false)
    {
        $payout = [];
        // $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout;
                   
              
        // $credit_logs =  $user->psychic_credit_logs()->orderBy('created_at','DESC')->get();
        // $startstrontime = (date('D')=== 'Mon') ? strtotime('now'):strtotime('last monday');       
        // $endStronTime = strtotime('next sunday');
        // $first = date('Y-m-d', $startstrontime);
        // $last =  date('Y-m-d', $endStronTime);  
        // $current_balance_net = $credit_logs->whereBetween('created_at',[$first,$last])->sum('credits');

        // $refund = $credit_logs->where('action', 'REFUND')->whereBetween('created_at',[$first,$last])->sum('credits');  
        //Current Ballance      
        $payout['current_balance'] = PayoutUtils::get_current_balance($user);//number_format((float)(($current_balance_net) * $percent_to_pay/100), 2);

        

        if($earning){
            return array_merge(
                $payout,
                ['earning' => PayoutUtils::get_all_time_earnings($user)]
            );
        }
        
        $payout_log = $user->psychic_payout_logs()->orderBy('created_at','DESC')->get();
        
        // Payouts Paid     
        $payout_completed = PayoutUtils::get_payouts_completed($payout_log);
        $payout['payouts_paid'] = $payout_completed->sum('payout'); 


        //Payout Pending        
       
        $payout_pending = PayoutUtils::get_payouts_to_pay($user); 
        //print_r($payout_pending->get());
        $upcoming_payment = $payout_pending->first();
        $upcoming_payment_day ='-';
        if($upcoming_payment){
            $upcoming_payment_day = date('m/d/Y',strtotime($upcoming_payment['pay_day']));
        }
        $payout['payouts_pending'] = ['total_amount'=>round($payout_pending->sum('payout'),2),                                        
                                      'upcoming_payment_day' => $upcoming_payment_day];   

    
        return $payout;
    }

    public function payPeriod(){
        $startstrontime = (date('D')=== 'Mon') ? strtotime('now'):strtotime('last monday');       
        $endStronTime = strtotime('next sunday');
        return date('d/m/Y',$startstrontime).' - '.date('d/m/Y',$endStronTime);
    }
    public function getAmount($amount){
        $amount_to_pay = str_replace(',', '', $amount);
        if (is_numeric($amount_to_pay)) {           
           return $amount_to_pay;
        }
        throw new \Exception("Invalid number to format: $amount_to_pay");
    }
}