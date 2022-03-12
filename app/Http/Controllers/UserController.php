<?php

namespace App\Http\Controllers;


use App\Http\Resources\v1\CategoryResourceCollection;
use App\Http\Resources\v1\AppointmentCalendarResourceCollection;
use App\Models\Category;
use App\Models\Appointment;
use App\Models\Country;
use App\Models\Country_all;
use App\Models\States;
use Camroncade\Timezone\Timezone;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BillingUtils;
use App\Models\UserCreditLog;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\v1\UserCreditLogsResourceCollection;

class UserController extends Controller
{
    public function __construct(Guard $auth)
    {

        $this->middleware('auth');
        $this->middleware('role:2')->except(['notifications']); //change later to user role
        $this->middleware('verifyphone');
        $this->middleware('verifield');
        $this->auth = $auth;
    }

    public function payout_method(Request $request)
    {
        //return view('frontend.model')->with(['id'=> $id, 'user'=> Auth::user(), 'guest'=> Auth::guest()]);

        return view('backend.payout_method');
    }

    public function userAppointments(Request $request)
    {
        $apid = $request->get('apid') ? $request->get('apid') : '';
        $categories = new CategoryResourceCollection(Category::all());
        return view('backend.user_dashboard', [
            'link' => 3,
            'categories' => $categories,
            'apid' => $apid
        ]);
    }
    public function replays()
    {
        return view('backend.dashboard_replays')->with(['link' => 6]);
    }
    public function dashboard_menu()
    {

        return view('backend.dashboard_menu')->with(['link' => 5]);;
    }


    
    
    public function subscriptions(Request $request)
    {
        $apid = $request->get('apid') ? $request->get('apid') : '';
        $categories = new CategoryResourceCollection(Category::all());
        return view('backend.dashboard_reviews', [
            'link' => 2,
            'categories' => $categories,
            'apid' => $apid
        ]);
    }


    
    public function transaction()
    {

        $credit_logs =  Auth::user()->user_credit_logs()->orderBy('created_at', 'DESC')->get();

        $logs = new UserCreditLogsResourceCollection($credit_logs);

        $user = Auth::user();

        return view('backend.dashboard_transaction')->with(['transactions' => $logs, 'link' => 4, 'name' => $user->userProfile->name . ' ' . $user->userProfile->last_name]);
    }

    public function favorites(Request $request)
    {
        $apid = $request->get('apid') ? $request->get('apid') : '';
        $categories = new CategoryResourceCollection(Category::all());
        return view('backend.dashboard_favorites', [
            'link' => 1,
            'categories' => $categories,
            'apid' => $apid
        ]);
        //return view('backend.dashboard_favorites')->with(['link' => 3]);
    }
    
    public function userProfile()
    {
        $timezone = new Timezone();
        $timezone_list = $timezone->getTimezones();
        $countries = Country::all();
        $states = States::all();

        $country_obj = new Country_all();
        $country_all = $country_obj->get_all_countries();
        return view('backend.user_profile')->with(['link' => 0, 
            'countries' => $countries, 'states' => $states,
            'timezones' => $timezone_list, 'country_all' => $country_all
        ]);
    }
    public function userPayment()
    {   

        $user = Auth::user();

        $card = '';
        $cards = BillingUtils::get_user_cards($user->id, $card);
        //dd($cards);
        return view('backend.user.payment')->with(['cards' => $cards, 'link' => 5]);
    }
    public function notifications()
    {
        $user = Auth::user();
        return view('backend.notifications')->with(['user' => $user, 'link' => '']);;
    }
}
