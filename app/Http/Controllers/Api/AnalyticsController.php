<?php namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\ChatAuth;
use App\model_chat_show;
use App\Models\fan_chat_room;
use App\Models\model_chat_room;
use App\Models\User;
use App\Models\ProfileViews;
use App\Models\UserCreditLog;
use App\Models\user_1_1_chat_request;
use App\Services\ChatRoomUtils;
use App\Services\NotificationUtils;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ApiUtils;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserCreditLogsResourceCollection;
use App\Services\PayoutUtils;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller {

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api'); 
        $this->middleware('role:1');      
        $this->auth = $auth;
    }

    
    public function get_psychic_income_analytic(Request $request)
    {

      
            $result = $this->get_profile_income($request->months);

       return $result;
     
      
      


    }
    public function get_profile_income($total_months){
        
        
        $months_before = $total_months;
        $today = date('Y-m-d');
        $months =[];
        $credits =[]; 
        $net_income_aux =0;
        $net_income_total = 0;
        $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout;       
      
        $result=[];
        if($months_before>0){
            for ($i= $months_before ; $i > 0   ; $i--) { 

                $last_month = date('Y-m-d', strtotime("-".$i." months") );
                $first = date('Y-m-01', strtotime($last_month));
                $last =  date('Y-m-t', strtotime($last_month));
                $month =date("M", strtotime($first));
    
                $net_income_credits = UserCreditLog::where(['psychic_id'=> Auth::user()->id ])
                ->whereBetween('created_at',[$first,$last])->sum('credits');
                $income_credits = $net_income_credits * $percent_to_pay/100;
                $net_income_total += $income_credits;
            
                array_push($months,$month);
                array_push($credits,$income_credits);               
             
            }     
        }
            $first = date('Y-m-01', strtotime($today));
            $last =  date('Y-m-t', strtotime($today));
            $month =date("M", strtotime($first));
    
            $net_income_credits = UserCreditLog::where(['psychic_id'=> Auth::user()->id])
            ->whereBetween('created_at',[$first,$last])->sum('credits');
            $income_credits = $net_income_credits * $percent_to_pay/100;
            $net_income = $income_credits + $net_income_total;
           
            
                array_push($months,$month);
                array_push($credits,$income_credits);
        


       
       


            array_push($result,['months'=> $months,'views'=>$credits,'net_income'=>number_format((float)$net_income,2)]);

          return $result;
    }
    
    public function get_psychic_overview_analytic(Request $request)
    {      
        
        $result = $this->get_profile_views($request->months);

       return $result;

    }
    
    public function get_psychic_stream_analytic(Request $request)
    {
        $t=($request->t)?"Video Chat":"";
        $result = $this->get_stream_insight($request->months,$t);
        return $result;
    }
    
    public function get_stream_insight($month,$t)
    {
        $first="";
        $result=[];
        $date_stream=$itemsTop=[];
        
        
        $q = DB::table('user_credit_log as uc')//UserCreditLog::where('psychic_id','=' ,Auth::user()->id)
            ->select(DB::raw('sum(uc.credits) as credit'),'uc.user_id',DB::raw("CONCAT(user_profile.name,' ' ,user_profile.last_name) as viewname "))
            ->join('user_profile', 'uc.user_id', '=', 'user_profile.user_id')
            ->where('uc.psychic_id', Auth::user()->id)
            ->whereRaw( "MONTH(uc.created_at) = ? ", $month )
            ->whereRaw( "YEAR(uc.created_at) = ? ", date("Y") )            
            ->groupBy('uc.user_id',DB::raw('CONCAT(user_profile.name,user_profile.last_name)'))
            ->orderBy(DB::raw('sum(uc.credits)'),"desc")
            ->limit(10);
        
        if($t!="")
            $q->where('uc.action',"=",$t);
        
        $credits=$q->get();
                
        foreach($credits as $c)
        {
            $itemsTop[]=array("name"=> $c->viewname,"credit"=>$c->credit);
        }
        if(count($itemsTop)<1)
            $itemsTop[]=array("name"=> "");
        
        
        $q = DB::table('user_credit_log as uc')//UserCreditLog::where('psychic_id','=' ,Auth::user()->id)
            ->select(DB::raw("distinct(DATE_FORMAT(uc.created_at,'%m/%d/%Y')) as date_created"))
            ->where('uc.psychic_id', Auth::user()->id)
            ->whereRaw( "MONTH(created_at) = ? ", $month )
            ->whereRaw( "YEAR(created_at) = ? ", date("Y") )
            ->orderBy('uc.created_at',"asc");            
        
        if($t!="")
            $q->where('uc.action',"=",$t);
        
        $dates=$q->get();
        
        foreach($dates as $d)
        {
            $date_stream[]=array("text"=> $d->date_created,"value"=>$d->date_created);
        }
        
        
        $q = DB::table('user_credit_log as uc')//UserCreditLog::where('psychic_id','=' ,Auth::user()->id)
            ->select(DB::raw("sum(credits) as credits"))
            ->where('uc.psychic_id', Auth::user()->id)
            ->whereRaw( "MONTH(created_at) = ? ", $month )
            ->whereRaw( "YEAR(created_at) = ? ", date("Y") )            
            ->orderBy('uc.created_at',"asc");            
        
        if($t!="")
            $q->where('uc.action',"=",$t);
        
        $earn=$q->get();
        $earned=0;
        if(count($earn)>0)
            $earned=$earn[0]->credits;
        
        
        $q = DB::table('user_credit_log as uc')//UserCreditLog::where('psychic_id','=' ,Auth::user()->id)
            ->select(DB::raw("count(user_id) as npurchased"))
            ->where('uc.psychic_id', Auth::user()->id)
            ->whereRaw( "MONTH(created_at) = ? ", $month )
            ->whereRaw( "YEAR(created_at) = ? ", date("Y") )
            ->orderBy('uc.created_at',"asc");
        
        if($t!="")
            $q->where('uc.action',"=",$t);
        
        $purc=$q->get();
        
        $purchased=0;
        if(count($purc)>0)
            $purchased=$purc[0]->npurchased;
        
        
        $q = DB::table('model_chat_room as cm')//UserCreditLog::where('psychic_id','=' ,Auth::user()->id)
            ->select(DB::raw("count(uo.opinion) as count,uo.opinion"))
            ->join('fan_chat_room as cf', 'cf.model_chat_room_id', '=', 'cm.id')
            ->join('user_opinion as uo', 'cf.id', '=', 'uo.fan_chat_room_id')
            ->where('cm.model_id', Auth::user()->id)
            ->groupBy('uo.opinion');
        
        $likes=$q->get();
        $like=[];
        foreach($likes as $l)
            $like[$l->opinion]=$l->count;
        
        if($like["POSITIVE"])
        {
            $likep=round(($like["POSITIVE"]/($like["POSITIVE"]+(isset($like["NEGATIVE"])?$like["NEGATIVE"]:"0")))*100)."% Liked";
        }
        
        //$date_stream="";
        
        array_push($result,[
            'date_stream'=> $date_stream,
            'itemsTop'=>$itemsTop,
            "purchased"=>$purchased,
            "earned"=>$earned,
            "like"=>$likep
        ]);

        return $result;
    }
    
    public function get_profile_views($total_months){
        
        
        $first="";
        $result=[];
        
        $data= array();
        $q = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)
            ->select(DB::raw('sum(credits) as credit'),DB::raw('MONTH(created_at) as month'),DB::raw('YEAR(created_at) as year'),DB::raw('`action` as service'))
            ->whereIn('action',['Chat','Video Chat','Call','Tip'])
            ->groupBy(DB::raw('MONTH(created_at)'),DB::raw('YEAR(created_at)'),DB::raw('`action`'))
            ->orderBy(DB::raw('YEAR(created_at) '))
            ->orderBy(DB::raw('MONTH(created_at)'));
        if($total_months!="-1")
        {
            $months_before = $total_months;
            $today = date('Y-m-d');
            $months =[];
            $views =[];
            $psychic_session=[];
            $result=[];
            $last_month = date('Y-m-d', strtotime("-".$total_months." months") );
            $first = date('Y-m-01', strtotime($last_month));
            $q->where('created_at', '>=',$first);
        }
        
        $credits=$q->get();
        
        $calls=$video=$chats=$tips=$subscriptions=$months=array();
        $total_subscriptions=$total_tips=$total_chats=$total_video=$total_calls=0;

        foreach ($credits as $c) {
            if($c->service!="")
            {
                if(!isset($data[str_pad($c->month, 2, "0", STR_PAD_LEFT)."-".$c->year]))
                {
                    $data[str_pad($c->month, 2, "0", STR_PAD_LEFT)."-".$c->year]=array('Call'=>0,'Chat'=>0,'Video Chat'=>0,'Tip'=>0);
                }                
                $data[str_pad($c->month, 2, "0", STR_PAD_LEFT)."-".$c->year][$c->service] =  $c->credit;
            }
        }   
        $first_month=$last_month="";
        foreach($data as $m=>$d)
        {
            $first_month=($first_month=="")?$m:$first_month;
            $last_month=$m;
            $months[]=$m;
            $subscriptions[]=0;                
            $tips[]=round($d["Tip"],2);
            $chats[]=round($d["Call"],2);
            $video[]=round($d["Chat"],2);
            $calls[]=round($d["Video Chat"],2);

            $total_subscriptions=0;
            $total_tips+=round($d["Tip"],2);
            $total_chats+=round($d["Call"],2);                
            $total_video+=round($d["Chat"],2);
            $total_calls+=round($d["Video Chat"],2);
        }

        if(count($months)<1)
        {
            $months[]="";
            $subscriptions[]=0;
            $tips[]=0;
            $chats[]=0;
            $video[]=0;
            $calls[]=0;
        }    
            
        array_push($result,[
            'months'=> $months,
            'subscriptions'=>$subscriptions,
            'tips'=>$tips,
            "chats"=>$chats,
            "video"=>$video,
            "calls"=>$calls,
            'total_subscriptions'=>$total_subscriptions,
            'total_tips'=>$total_tips,
            "total_chats"=>$total_chats,
            "total_video"=>$total_video,
            "total_calls"=>$total_calls,
            "first_month"=>$first_month,
            "last_month"=>$last_month
        ]);

        return $result;
    }
    
    function get_psychic_earnings_analytic(){


        $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout; 
        $count_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
        {
            $q->where('service_id',1)->orWhere('service_id',3);
        })->count();

        // $count_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
        // {
        //      $q->where('action','Video Chat')->orWhere('action','Calling');
        // })->count();

        $min_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
        {
            $q->where('service_id',1)->orWhere('service_id',3);
        })->sum('duration');

       
         if(!$count_sessions || !$min_sessions){
             $avg = 0;
         }else{
             $avg = $min_sessions/$count_sessions;
         }


         $income_credits = UserCreditLog::where(['psychic_id'=> Auth::user()->id])
         ->sum('credits');
         if(!$income_credits || !$count_sessions){
            $avg_earnings = 0;
        }else{
            
            $income_credits_aux =  $income_credits * $percent_to_pay/100;
            $avg_earnings = $income_credits_aux/$count_sessions;
        }

        $today = date('Y-m-d');
        $first = date('Y-m-01', strtotime($today));
        $last =  date('Y-m-t', strtotime($today));
       

        
            $earning_this_month = UserCreditLog::where(['psychic_id'=> Auth::user()->id])
            ->whereBetween('created_at',[$first,$last])->sum('credits') * $percent_to_pay/100;

            $earning_today = UserCreditLog::where(['psychic_id'=> Auth::user()->id])->whereDate('created_at','=',$today)
           ->sum('credits')  * $percent_to_pay/100;

        return [ 'total_sessions'=>$count_sessions,
                 'minutes'=>intval($min_sessions),
                 'avg_minutes_x_session'=>round($avg,2),
                 'avg_earnings_x_session'=>number_format((float)$avg_earnings,2),
                 'earning_this_month' => number_format((float)$earning_this_month,2),
                 'earning_today' => number_format((float)$earning_today,2) ];
    }
    public function header_data_earning_reviews_views(Request $request)
    {
      $user = Auth::user();

      $total_earning = PayoutUtils::get_all_time_earnings();
      $all_payment_amount = PayoutUtils::get_all_time_earnings();   


      $current_balance =   PayoutUtils::get_current_balance();
     
      $reviews = $user->reviews()->count();

      $profile_views = $user->psychic_profile_views()->count();
      $rarting_reiews = $user->reviews()->sum('rating');
      $rating_reviews = $reviews >0 && $rarting_reiews>0 ? intval($rarting_reiews)/intval($reviews): 0;
      $data = ['t_earning'=> number_format((float)$total_earning,2),'current_balance'=> number_format((float)$current_balance,2), 'reviews_rating'=> round($rating_reviews,1), 'reviews'=> $reviews, 'p_views' => $profile_views];

      if($user->role_id == WhiteLabel::roleId('Model')){
          $data['link'] =  $user->userProfile->profile_link ?? $user->userProfile->display_name;
      }
       return  ApiUtils::response_success($data); 
           
            
   
    }


    


}
