<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhiteLabel;
use App\Models\PayoutLog;
use App\Services\PayoutUtils;

use App\Models\User;

class cron_payout_record_process extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron_payout_record_process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron PayOut Record Proccess Create PayOut Log';

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
        echo '***********   Date: '.now().'    ***********'. PHP_EOL;    
        $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout;
        $startStrTotime =strtotime('last monday');    
        $endStrToTime = strtotime('last sunday');
        //$endStrToTime = strtotime('last sunday');
        $start = date('Y-m-d',$startStrTotime);
        $end =   date('Y-m-d',$endStrToTime);

        $compareEndDay = date('Y-m-d',strtotime($end. '+ 1 days')); 
        $pay_day = date('Y-m-d',strtotime($end. '+ 7 days')); 
        echo 'Period: '.$start. '  -------  ' .$end.  PHP_EOL;   
        echo 'Pay Date: '.$pay_day.  PHP_EOL;
        echo 'Percent to pay: '.$percent_to_pay.  PHP_EOL;   
        
        $users = User::where(['role_id'=>1,'email_validated'=>1])->get();

        foreach ($users as $user) {

            //S_REFUND 
            echo 'Model with id: '.$user->id.' status: Processing'; 
            $current_balance_net_withoutrefund = $user->psychic_credit_logs()  
                                        ->where('action','<>','REFUND')                                      
                                        ->whereBetween('created_at',[$start,$compareEndDay])
                                        ->sum('credits');

            $current_balance_net_refunded = $user->psychic_credit_logs()
                                        ->where('action','=','REFUND')                                      
                                        ->whereBetween('created_at',[$start,$compareEndDay])
                                        ->sum('credits');

            $current_balance_net = $current_balance_net_withoutrefund - $current_balance_net_refunded;                            
                                                     
             
            $current_balance = $current_balance_net * 0.8;

            echo  '--Net: $'.$current_balance_net.'---';
            $payOutLog = new PayoutLog();
            if($current_balance_net != 0){
               
                
                $payOutLog->psychic_id = $user->id;
                $payOutLog->earnings = $current_balance_net;
                $payOutLog->payout = $current_balance;
                $payOutLog->pay_day = $pay_day;
                $payOutLog->start_period = $start;
                $payOutLog->end_period = $end;
                $payOutLog->status = 'Pending';
                $payOutLog->save();
                echo '**Processed---$'.$current_balance. PHP_EOL;       
            }else{
                echo '**No Earnings**'. PHP_EOL;   
            }                    
                 
            
                    //Prepare to next payout and put en queque
                    $get_payouts_to_pay_next = PayoutUtils::get_payouts_to_pay_next($user,'asc'); 
                    $total_to_pay_next = $get_payouts_to_pay_next->sum('payout');
                    $sum_payouts = 0;
                    if($total_to_pay_next >= 75) {
                        
                         // Fisrt check if exist payouts en queque to pay 
                        $get_payouts_current_pay = PayoutUtils::get_payouts_current_pay($user); 
                        $get_payouts_to_pay_nextToMod = $get_payouts_to_pay_next->get();  
                        $i = 0;

                        if(!$get_payouts_current_pay->first()){

                                           
                        foreach($get_payouts_to_pay_nextToMod as $item){

                            echo '**Prepare no next payout---Id: '.$item->id. PHP_EOL; 
                           
                            $sum_payouts = $sum_payouts + $item->payout;
                            $item->upcoming = 'UPCOMING';
                            $item->save();

                            if($sum_payouts >= 75){
                            $item->payout_to_pay = $sum_payouts; 
                            $item->save();
                            break;                  
                            }               
                           
                           
                            //$i++;     
                        }
                     }
                     else{
                        foreach($get_payouts_to_pay_nextToMod as $item){

                            echo '**Prepare no next payout---Id: '.$item->id. PHP_EOL; 

                            $sum_payouts = $sum_payouts + $item->payout;                           
                            $item->save();
                            if($sum_payouts >= 75){
                            $item->payout_to_pay = $sum_payouts; 
                            $item->save(); 
                            $sum_payouts = 0;
                            //break;                 
                            }
                           
                            //$i++;     
                        }

                     }               
                 }
            
        }
        echo '***********  End Date:  '.now().'  ******************************************************'. PHP_EOL; 
        echo  PHP_EOL; 
      
    }
}
