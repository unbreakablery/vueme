<?php

namespace App\Services;
use DB;
use App\Http\Trails\SearchUser;
use App\Services\BillingUtils;
use App\Services\WhiteLabel;
use App\Models\PayoutLog;
use Illuminate\Support\Facades\Auth;

class PayoutUtils
{
   use SearchUser;
    public static function get_payouts_to_pay($user, $startPeriod = false)
    {

       $today = date('Y-m-d');
       $query = $user->psychic_payout_logs()        
        ->where([['status', '=' , 'Pending'],['upcoming','=','UPCOMING']]);
        if(!$startPeriod)
        $query->whereDate('pay_day','<=',$today)        
        ->orderBy('id','DESC');
        else 
        $query->whereDate('start_period','<=', $startPeriod->add(6, 'days'))        
        ->orderBy('id','DESC');
        return   $query;

    }   
    public static function get_payouts_to_pay_next($user,$orderBy = null)
    {

      return   $user->psychic_payout_logs()
        ->where([['status', '=' , 'Pending'],['upcoming','=',NULL]]) 
        ->orderBy('id', $orderBy ? $orderBy : 'desc');
        return   $query;

    }        
    public static function get_payouts_completed($payout_log, $startPeriod = false){
      
      if($startPeriod)
       return $payout_log->where('status','=','Paid')->where('created_at', '>=', $startPeriod->startOfDay())->where('created_at', '>=', $startPeriod->copy()->add(6,'days')->endOfDay());   
     return  $payout_log->where('status','=','Paid');   
    }
    public static function get_minimum_payout_psychic($user){
       
       $card = 'DEPOSIT'; 
       $minimum_payout = WhiteLabel::config('accounting')->minimum_payout;
       return $minimum_payout;

       $minimum_international_payout = WhiteLabel::config('accounting')->minimum_international_payout;
       $minimum_payout_to_return= $minimum_payout;     
        $cards = BillingUtils::get_user_cards($user->id, $card);

        if(count($cards)==0 && $user->paypal_account){
            $minimum_payout_to_return= $minimum_international_payout;            
        }  
        
        return $minimum_payout_to_return;

    }
    public static function get_payouts_current_pay($user, $orderBy=null){
      
      return   $user->psychic_payout_logs()
        ->where([['status', '=' , 'Pending'],['upcoming','=','UPCOMING']])
        ->orderBy('id', $orderBy ? $orderBy : 'desc');
        return   $query;
    }
    public static function get_amount_to_pay($credits){
        return $credits * WhiteLabel::config('accounting')->percent_to_payout/100;
    } 
    public static function get_all_time_earnings($user = null){
      
      $user = $user ?? Auth::user();       
      $current_balance = PayoutUtils::get_current_balance($user);
      $all_time_earnings = $user->psychic_payout_logs()->sum('payout') + $current_balance; 
     
      return $all_time_earnings;
    }
    public static function get_current_balance($user = null, $startPeriod = false){

      $user = $user ?? Auth::user();

      if(!$startPeriod){
        $startstrontime = (date('D')=== 'Mon') ? strtotime('now'):strtotime('last monday');       
      $endStronTime = strtotime('next sunday');        

      $first = date('Y-m-d', $startstrontime);
      $last =  date('Y-m-d', $endStronTime); 
      }
      else{
        $first = $startPeriod;
      $last =  $startPeriod->copy()->add(6, 'days');
      }

      $credit_logs = $user->psychic_credit_logs;

      $current_balance_net_withoutrefund = $credit_logs->whereBetween('created_at',[$first,$last])
                                          ->where('action','<>','REFUND')  
                                          ->sum('credits'); 

      $current_balance_net_refunded = $credit_logs->whereBetween('created_at',[$first,$last])
                                          ->where('action','=','REFUND')  
                                          ->sum('credits');     
      
      $current_balance_net = $current_balance_net_withoutrefund - $current_balance_net_refunded;
      
      $current_balance =   PayoutUtils::get_amount_to_pay($current_balance_net);

      return $current_balance;

    }

}