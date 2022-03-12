<?php

namespace App\Http\Controllers;

use Storage;
use Validator;
use App\Models\Post;
use App\Models\User;

use App\Models\Tools;
use App\Models\Styles;
use App\Models\Category;
use App\Services\ApiUtils;

use App\Services\WebUtils;
use App\Models\Country_all;



use App\Models\Specialties;
use Jenssegers\Agent\Agent;
use App\Models\BlogEtcPosts;
use App\Models\ProfileViews;

use App\Models\Subscription;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use App\Models\HoroscopeInfo;
use App\Services\TwilioUtils;
use App\Models\UserBillerEdata;
use Camroncade\Timezone\Timezone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\HoroscopeZodiacSigns;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\v1\GenericResource;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\UserBasicResource;
use App\Http\Resources\v1\BlogEtcPostsResource;


use App\Http\Resources\v1\ModelProfileResource;
use App\Http\Resources\v1\HoroscopeInfoResource;
use Camroncade\Timezone\TimezoneServiceProvider;
use App\Http\Resources\v1\CategorySearchResource;
use App\Http\Resources\v1\CategoryResourceCollection;
use App\Http\Resources\v1\HoroscopeZodiacSignsResource;
use App\Http\Resources\v1\BlogEtcPostsResourceCollection;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Http\Resources\v1\HoroscopeInfoResourceCollection;
use App\Http\Resources\v1\CategorySearchResourceCollection;
use App\Http\Resources\v1\HoroscopeZodiacSignsResourceCollection;


class FrontController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $successStatus = 200;

    public function __construct()
    {
        $this->middleware('verifyphone')->except('verificationForm', 'ajaxLogin');
        $this->middleware('verifield')->except('ajaxLogin');      
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.home')->with(['user' => Auth::user(), 'guest' => Auth::guest()]);
    }


    public function get5Free()
    {

        return view('frontend.get5_free')->with(['user' => Auth::user(), 'guest' => Auth::guest()]);
    }

    public function changepass(Request $request){
        $token = $request["token"];
        $email = $request["email"];
        $password = $request["current_password"];

        $request->validate([
            'current_password' => 'required|string|min:6',
            'new_password' =>     'required|string|min:6'
        ]);
        
        $mifecha    = date('Y-m-d H:i:s');
        $NuevaFecha = strtotime('-2 hour', strtotime($mifecha));
        $NuevaFecha = date('Y-m-d H:i:s', $NuevaFecha);
        $token_reco = DB::table('password_resets')->where("email",$email)
        ->where("created_at",">=",$NuevaFecha )->first();
        if(!empty($token_reco)){
            if(Hash::check($token,$token_reco->token)){
                DB::table('user')->where("email",$token_reco->email)
                ->update(["password"=>Hash::make( $request["new_password"])]);
                DB::table('password_resets')->where("email",$email)
                ->update(["created_at"=>null]);
                return array("status"=>"OK");
            }else{
                return response()->json([
                    'message' => 'Unauthorized',
                    "errors"=>["email_addres"=>["The password recovery link has expired, generate a new link"]]
                ], 422);
            }

        }else{
            return response()->json([
                'message' => 'Unauthorized',
                "errors"=>["email_addres"=>["The password recovery link has expired, generate a new link"]]
            ], 422);
        }


    }
    public function reset_password(Request $request,$token=null){


        $message = "";
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $email=$request["email"];
        try {
            $ad = explode("?",$actual_link);
            $email =str_replace("email=","",$ad[1]);
        } catch (Exception $e) {
           
        }
        


        return view('auth.passwords.reset', array('notice' => $message, "token_user"=>$token, "email_user"=> $email, 'phone' => "", 'user' => "", 'redirect' => "/") );


    }
    public function verificationForm(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect("/");
        }
        $phoneNumber = $user->user_mobile_nums()->first();

        if ($phoneNumber && $phoneNumber->validated) {
            return redirect("/");
        }
        $country_obj = new Country_all();
        $country_all = $country_obj->get_all_countries();



        if ($phoneNumber && !is_null($phoneNumber->code2) && !is_null($phoneNumber->number) && !empty($phoneNumber->code2) && !empty($phoneNumber->number)) {
            if (is_null($phoneNumber->verification_code) || empty($phoneNumber->verification_code)) {

                $code = rand(1000, 9999); //generate random code
                $phoneNumber->verification_code = $code; //save code
                $phoneNumber->save();

                TwilioUtils::send_verification_sms($phoneNumber, $user);
            }
            $message = "Code Sent to: <b>+" . $phoneNumber->prefix . $phoneNumber->number . "</b>";
            return view('frontend.verify_phone')->with(array('notice' => $message, 'phone' => $phoneNumber, 'user' => new UserBasicResource($user), 'redirect' => $request->session()->get('redirect_url')));
        } else {
            $message = "Please update your phone number, we will text you a verification code.";
            return view('frontend.add_verify_phone')->with(array('notice' => $message, 'phone' => $phoneNumber, 'user' => new UserBasicResource($user), 'country_all' => $country_all, 'redirect' => $request->session()->get('redirect_url')));
        }
    }

    public function psychicRedirect(Request $request)
    {


        $REFERER = $request->server('HTTP_REFERER');
        if (!is_null($REFERER) && !empty($REFERER)) {
            session(['redirect' => $REFERER]);
        }

        return redirect("/apply");
    }

    public function model($slug)
    {


        return view('frontend.model')->with(['slug' => $slug, 'user' => Auth::user(), 'guest' => Auth::guest()]);
    }

    public function categories()
    {
        return view('frontend.categories')->with(['user' => Auth::user(), 'guest' => Auth::guest()]);;
    }

    public function category($slug)
    {
        $cat = Category::where('slug', $slug)->get()->first();
        $cat_name = $cat->name;
        $cat_description = $cat->description;
        return view('frontend.category', compact('slug', 'cat_name', 'cat_description'));
    }

    public function favorites()
    {
        if (Auth::check()) {
            return view('frontend.favorites')->with(['user' => Auth::user(), 'guest' => Auth::guest()]);
        } else {
            return redirect("/login");
        }
    }

    public function helpfuls()
    {
        if (Auth::check()) {
            return view('frontend.helpfuls')->with(['user' => Auth::user(), 'guest' => Auth::guest()]);
        } else {
            return redirect("/login");
        }
    }

    public function ajaxLogin(Request $request)
    {


        if (Auth::check()) {
            return ApiUtils::response_success();
        }

        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);


        $request->merge([
            'email' => trim($request->email),
            'password' => trim($request->password),
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return ApiUtils::response_fail_mobile_num(['email'=>['account not found']],"The given data was invalid."); 
            //return ApiUtils::response_fail('These credentials do not match our records.');
        }

        if ($user['account_status'] == 'ADMIN_DISABLED') {
            return ApiUtils::response_fail('Your account is disabled. Please contact support@collide.com for assistance');
        }

        if (!$user->email_validated)
            return ApiUtils::response_fail('Inactive Login - please contact support@psychics1on.com for assistance.', 401);

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {

            $role = $user->role_id;
            $url = "/login";
            $url_intended =  FacadesSession::get('url.intended', url('/'));
            if ($role == WhiteLabel::roleId('Admin') || $role == WhiteLabel::roleId('Agency') || $role == WhiteLabel::roleId('Support') || $role == WhiteLabel::roleId('Horoscope')  || $user->email == 'blake@respectfully.com' || $user->email == 'account@respectfully.com') {
                $url =  '/admin';
            }
            elseif ($role == WhiteLabel::roleId('Blog')) { //change-agency
                // $url = $url_intended;
                $url = '/agency';
            } elseif ($role == WhiteLabel::roleId('Model')) {
                // $url = $url_intended;
                $url = '/dashboard';
            } elseif ($role == WhiteLabel::roleId('User')) {
                $url = $url_intended;
                //$url =  null;//reload same page
            }

            if ($request->session()->has('redirect')) {
                $url = session('redirect');
                $request->session()->forget('redirect');
            }

            if ($user->email_validated) {
                return ApiUtils::response_success(['success' => true, 'url' => $url], $this->successStatus);
            }
        }
        return ApiUtils::response_fail_mobile_num(['password'=>['password does not match our records']],"The given data was invalid."); 
        //return ApiUtils::response_fail('Invalid email/password, please try again');
    }

    public function terms()
    {


        /*$users = User::all();

        foreach ($users as $user){

            if(!is_null($user->userProfile()->first())){
                $profile = $user->userProfile()->first();
                $display_name = WebUtils::seoUrl($profile->display_name);
                $profile->display_name = $display_name;
                $profile->save();
            }

        }*/

        return view('frontend.terms');
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }
    public function dmca_policy()
    {
        return view('frontend.dmca_policy');
    }


    public function paymentterms()
    {
        return view('frontend.payment-terms');
    }
    public function cookies()
    {
        return view('frontend.cookies');
    }

   
    public function specialtie($display_name, $review = null)
    {

        $user = Auth::user();
        
        $model = User::select('user.id', 'user.is_streaming_live','user.appointment_live')->join('user_profile', 'user.id', '=', 'user_profile.user_id')
            ->where('user_profile.profile_link', $display_name)
            ->where('user.email_validated', 1)
            ->where('user.role_id', '=', WhiteLabel::roleId('Model'))
            ->get()->first();

        if (is_null($model)) {
            return redirect("/");
        }        


        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        if (!$pageWasRefreshed) {
            $proView = new ProfileViews();
            $model->psychic_profile_views()->save($proView);
        }

        // $timezone = new Timezone();
        // $timezone_list = $timezone;
        // $current_user_timezone = null;
        // $current_user_appointment_count = 0;

        // if ($user) {
        //     $current_user_appointment_count = $user->user_appointments()->count();
        //     $current_user_timezone = $user->userProfile()->first()->timezone;
        // }

        $profile_bio = substr($model->user_profile->description, 0, 157) . '...';

       


        return view('frontend/specialtie-profile', [
            'user' => $user ? new GenericResource($user, ['role_id']) : null,
            // 'current_user_timezone' => $current_user_timezone,
            // 'current_user_appointment_count' => $current_user_appointment_count,
            // 'timezones' => $timezone_list,
            // 'browserAllow' => $allow,
            // 'browser' => $browser,
            'meta_description' => $profile_bio,
            'meta_link' => $model->userProfile->profile_link,            
            'page_title' => $model->userProfile->display_name,            
            'model' => new ModelProfileResource($model),
        ]);
    }
    public static function countries_all()
    {

        $country_obj = new Country_all();
        return $country_obj->get_all_countries();
    }

    public function press()
    {
        return view('frontend.press');
    }


    public function horoscope()
    {
        $blogs = new BlogEtcPostsResourceCollection(BlogEtcPosts::where('is_published', '=', 1 )->offset(0)->limit(2)->orderBy('id', 'DESC')->get()); 
        return view('frontend.horoscope')->with(array('blogs' => json_encode($blogs)));                                           
        
    }

    public function zodiacSign(Request $request)
    {

        $horoscope = HoroscopeZodiacSigns::select('horoscope_zodiac_signs.*')
        ->where('horoscope_zodiac_signs.slug',$request->slug)
        ->get()->first();

        $info = HoroscopeInfo::select('horoscope_info.*')
        ->where('horoscope_info.horoscope_zodiac_signs_id',$horoscope->id)
        ->whereDate('horoscope_info.start_week','<=', date('Y-m-d'))
        ->whereDate('horoscope_info.end_week','>=', date('Y-m-d'))
        // ->whereRaw('( ? >= horoscope_info.start_week AND ? <= horoscope_info.end_week) ',[date('Y-m-d'),date('Y-m-d')])
        // ->where('horoscope_info.end_week','<=',date('Y-m-d'))
        ->get()->first();

        $country_obj = new Country_all();
        $country_all = $country_obj->get_all_countries();
        
        $horoscope = new HoroscopeZodiacSignsResource($horoscope);
        
        if($info) $info = new HoroscopeInfoResource($info);

        
        
        return view('frontend.zodiac_sign')->with(array('horoscope' => json_encode($horoscope), 
                                                        'info' => json_encode($info),
                                                        'country_all' => json_encode($country_all),
                                                        'datetoday' => json_encode(array('d'=>date('d'),
                                                                                         'm'=>date('F'),
                                                                                         'y'=>date('Y')
                                                                                        ))
                                                        ));
                                            


    }

    

    public function signUpPage(Request $request)
    {

        if (Auth::check()) {
            return redirect("/dashboard");
        }
        
        if($request->display_name){

            $referral = User::select('user.id')->join('user_profile', 'user.id', '=', 'user_profile.user_id')
            ->where('user_profile.profile_link', $request->display_name)
            ->get()->first();

            if($referral)
            session(['join_id' => $referral->id]);

        }


        $country_obj = new Country_all();
        $country_all = $country_obj->get_all_countries();
        return view('frontend.page_signup')->with(array('country_all' => $country_all));
    }

    public function search(Request $request)
    {

        $seo_ability = null;
        
        
        if(!empty($request->input("ability"))){

            $abilities = explode(",",$request->input("ability"));
            if(count($abilities) == 1){
                $seo_ability =  Category::where('slug', $abilities[0])->first();
            }
        }
        
        

        return view('frontend/search', ['terms' => $request->all(), 'abilities'=> new CategorySearchResourceCollection(Category::all()), 'search' => true, 'seo_ability'=> $seo_ability]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect("/");
    }

    public static function abilities()
    {

        return Category::all();
    }

    public static function specialties()
    {

        return Specialties::all();
    }

    public static function tools()
    {

        return Tools::all();
    }

    public static function styles()
    {

        return Styles::all();
    }


    public function activity($slug)
    {

        return redirect("/search?ability=".$slug);
    }

    public function specialOffer()
    {
        $url = "http://3psychic.pagedemo.co/";    
        return Redirect::away($url);
        
    }
}
