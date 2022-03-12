<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\States;
use App\Models\Styles;
use App\Models\Country;
use App\Models\Category;


use App\Models\Languages;
use App\Models\Country_all;
use App\Models\Specialties;
use App\Models\Subscription;
use App\Services\WhiteLabel;

use Illuminate\Http\Request;


use App\Models\UserCreditLog;
use App\Services\PayoutUtils;
use App\Services\BillingUtils;
use App\Models\UserBillerEdata;
use Camroncade\Timezone\Timezone;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\v1\ToolsResourceCollection;
use App\Http\Resources\v1\StylesResourceCollection;
use App\Http\Resources\v1\SpecialResourceCollection;
use App\Http\Resources\v1\CategoryResourceCollection;
use App\Http\Resources\v1\LanguagesResourceCollection;
use App\Http\Resources\v1\PsychicCreditLogsResourceCollection;
use App\Http\Resources\v1\PsychicPayoutLogsResourceCollection;


class PsychicController extends Controller
{
    public function __construct(Guard $auth)
    {

        $this->middleware('auth');
        $this->middleware('role:1');
        $this->middleware('verifyphone');
        $this->middleware('verifield');       
        $this->auth = $auth;
      
    }

    public function payout_method(Request $request)
    {
        $user = Auth::user();

        $card = 'DEPOSIT';
        $cards = BillingUtils::get_user_cards($user->id, $card);

        if (count($cards) == 0 && $user->paypal_account) {
            $cards = [
                'account' => $user->paypal_account, 'account_type' => 'PayPal',
                'id' => $user->id, 'routing' => '', 'account_name' => $user->paypal_account, 'payment' => 'PayPal', 'country' => ''
            ];
        }

        $countries = Country::all();
        $states = States::all();
        $country_all = Country_all::all();
        $credit_logs =  Auth::user()->psychic_credit_logs()->orderBy('created_at', 'DESC')->get();
        $logs = new PsychicCreditLogsResourceCollection($credit_logs);

        $startstrontime = (date('D') === 'Mon') ? strtotime('now') : strtotime('last monday');
        $endStronTime = strtotime('next sunday');
        $start = date('m/d/Y', $startstrontime);
        $end =   date('m/d/Y', $endStronTime);
        $pay_period = $start . ' - ' . $end;
        $pay_period_short = date('m/d', $startstrontime) . ' - ' . date('m/d', $endStronTime);

        $current_balance =   PayoutUtils::get_current_balance();

        $payout = $user->psychic_payout_logs()->orderBy('id', 'DESC')->get();

        $all_payment_amount = PayoutUtils::get_all_time_earnings();


        //Payout details upcoming payment  
        $upcoming =  PayoutUtils::get_payouts_current_pay($user);
        $upcoming_payment_amount = $upcoming->sum('payout');
        //$upcoming_payment_amount = $payout->where('status','=','Pending')->sum('payout');        

        $upcoming_payment = $upcoming->first();
        $upcoming_payment_day = '-';
        $upcoming_payment_day_short= '';
        
        if ($upcoming_payment) {
            $upcoming_payment_day = date('m/d/Y', strtotime($upcoming_payment['pay_day']));
            $upcoming_payment_day_short = date('m/d/y', strtotime($upcoming_payment['pay_day']));
        }

        $pay_out_logs = new PsychicPayoutLogsResourceCollection($payout);
        $payout_details = [
            'current_balance' => number_format((float)$current_balance, 2), 'pay_period' => $pay_period, 'pay_period_short' => $pay_period_short,
            'upcoming_payment_amount' => number_format((float)$upcoming_payment_amount, 2), 'upcoming_payment_day' => $upcoming_payment_day,'upcoming_payment_day_short' => $upcoming_payment_day_short,
            'since' => $user->created_at,'since_short' => date('m/d/y', strtotime($user->created_at)),  'all_payment' => number_format((float)$all_payment_amount, 2)
        ];

        
        return view('backend.payout_method', [
            'link' => 5
        ])->with([
            'countries' => $countries,'country_all'=>$country_all, 'states' => $states,'methods' => $cards, 'transactions' => $logs,
            'payout_details' => $payout_details, 'payout_logs' => $pay_out_logs, 'name' => $user->userProfile->display_name
        ]);
    }

    public function cosmicRewards()
    {

        return view('backend.cosmic_rewards', [
            'link' => 6
        ]);

    }

    public function dashboard()
    {
        $categories = new CategoryResourceCollection(Category::all());
        return view('backend.dashboard', [

            'categories' => $categories,
            'link' => 3

        ]);
    }


    public function privateSchedule()
    {
        $categories = new CategoryResourceCollection(Category::all());
        
        return view('backend.private_schedule', [
            'categories' => $categories,
            'link' => 30
        ]);
    }



    public function dashboard_menu()
    {

        return view('backend.dashboard_menu')->with(['link' => 5]);;
    }

    public function psychicProfile($tab =0)
    {

        $timezone = new Timezone();
        $timezone_list = $timezone->getTimezones();
        
        $countries = Country::all();
        $states = States::all();
        $categories = new CategoryResourceCollection(Category::all());
        $specialties = new SpecialResourceCollection(Specialties::all());
        $tools = new ToolsResourceCollection(Tools::all());
        $styles = new StylesResourceCollection(Styles::all());
        $languages = new LanguagesResourceCollection(Languages::where('status','1')->get());
        
        $country_obj = new Country_all();
        $country_all = $country_obj->get_all_countries();

        // $specialties= array();

        $todoList = [];
        $count = 0;
        if($model = Auth::user()){
            
            if(is_null($model->userProfile->getOriginal('haedshot_path'))){
                $todoList['haedshot_path'] = ['missing' => true, 'link' => route('psychic_profile',["tab"=>1])];
            }
            else{
                $todoList['haedshot_path'] = ['missing' => false];
                $count++;
            }

            if(is_null($model->userProfile->description)){
                $todoList['description'] = ['missing' => true, 'link' => route('psychic_profile',["tab"=>1])];
            }
            else{
                $todoList['description'] = ['missing' => false];
                $count++;
            }

            if(Subscription::where('user_id', $model->id)->doesntExist()){
                $todoList['rate'] = ['missing' => true, 'link' => route('dashboard_services')];
            }
            else{
                $todoList['rate'] = ['missing' => false];
                $count++;
            }

            if(UserBillerEdata::where('user_id', $model->id)->doesntExist()){
                $todoList['bank_account'] = ['missing' => true, 'link' => route('dashboard_payout_method')];
            }
            else{
                $todoList['bank_account'] = ['missing' => false];
                $count++;
            }

            if($model->appointments()->count() == 0){
                $todoList['live'] = ['missing' => true];
            }
            else{
                $todoList['live'] = ['missing' => false];
                $count++;
            }
        }
        if($count == 5) $todoList = [];
        
        return view('backend.psychic_profile')->with([
            'countries' => $countries, 'states' => $states,'specialties' => $specialties,
            'tools' => $tools, 'styles' => $styles,'languages' => $languages,            
            'categories' => $categories, 'link' => 0, 'timezones' => $timezone_list, 'country_all' => $country_all,
            'todoList' => $todoList,
            "tab_select"=>$tab
        ]);


    }

    public function services()
    {
        $timezone = new Timezone();
        $timezone_list = $timezone->getTimezones();
        return view('backend.dashboard_services')->with(['link' => 2, 'timezones' => $timezone_list]);
    }

    public function psychicReplays()
    {

        return view('backend.psychic_reviews')->with(['link' => 4]);
    }




    
    public function psychicAnalytics()
    {
        return view('backend.psychic.psychic_analytics')->with(['link' => 7]);
    }
    public function referrals()
    {
        return view('backend.dashboard_referrals')->with(['link' => 8]);
    }
}
