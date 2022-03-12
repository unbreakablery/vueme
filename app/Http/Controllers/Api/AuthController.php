<?php
namespace App\Http\Controllers\Api;
use Validator;
use App\Models\User;
use App\Models\PromoCode;
use App\Models\UserWorks;
use App\Mail\SendGridMail;
use App\Models\VerifyUser;
use App\Services\ApiUtils;
use App\Services\WebUtils;
use App\Models\Country_all;
use App\Models\UserProfile;
use App\Models\UserService;
use App\Models\Subscription;
use App\Services\CacheUtils;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;

use Illuminate\Mail\Message;
use App\Models\UserCreditLog;
use App\Models\UserLanguages;
use App\Models\UserMobileNum;
use App\Services\TwilioUtils;
use App\Models\UserCredentials;
use Illuminate\Validation\Rule;
use App\Mail\RegisterSuccessEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Cast\Object_;



class AuthController extends Controller
{

    public $successStatus = 200;
    public $statusCreated = 201;

    public function __construct(Guard $auth/*,Register $registrar*/)
    {
        $this->auth = $auth;
        $this->create_user = null;
        $this->token = '';

    }

    public function postLogin(Request $request){


        if (Auth::check()) {
            return ApiUtils::response_success();
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->keys() as $key) {
                $errors[$key] = $validator->errors()->first($key);
            }
            return ApiUtils::response_fail_data('Please correct and try again.', $errors);
        }

        $request->merge([
            'email' => trim($request->email),
            'password' => trim($request->password),
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return ApiUtils::response_fail_data('Invalid email/password, please try again');
        }
       ;
        if ($user['account_status'] == 'ADMIN_DISABLED') {
            return ApiUtils::response_fail('Your account is disabled. Please contact support@collide.com for assistance');
        }

        if ($this->auth->attempt($request->only('email', 'password'), $request->has('remember'))) {

            if($user->email_validated){

               $success['token'] =  $user->createToken('Sexy1on1')->accessToken;
               $success['type'] =  'Bearer';
               return ApiUtils::response_success(['success' => $success], $this->successStatus);
                }else{

                return ApiUtils::response_fail(['message'=>'Please Verify Email'], 401);
                }


        }

        if ($this->auth->attempt(['username' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            $success['token'] =  $user->createToken('Sexy1on1')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);

           /* if($user->email_validated ){
                $success['type'] =  'Bearer';
                $success['token'] =  $user->createToken('Sexy1on1')->accessToken;

            return response()->json(['success' => $success], $this->successStatus);
                 }else{
                 return response()->json(['message'=>'Please Verify Email'], 401);
                 }*/

        }
        return ApiUtils::response_fail_data('Invalid email/password, please try again');


    }

    public function postRegister(Request $request, $test_mode = false) {



        $this->validate($request, [
            'name' => 'required',
            'last_name'=>'required',
            'code' => 'required',
            'number' => 'required|min:10|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
            'email' => 'required|email|unique:user',
            'categories' => 'required|array|min:1|max:4',
            /*'display_name' => 'required|min:3|unique:user_profile|regex:/^[a-zA-Z0-9_-]*$/',*/
            'display_name' => "required|min:3|max:46|unique:user_profile|regex:/^[a-z\d,.!'’?\-_\s]+$/i",
            'referral' => 'required',
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'c_password' => 'required|same:password',
            'age' => 'accepted',
        ]);


        if(!$this->validate_number($request)){
            return ApiUtils::response_fail_mobile_num(['number'=>['Mobile number is invalid']],"The given data was invalid.");         
         }  
        

        if (!empty($request['email'])) {
            $request['email'] = trim($request['email']);
        }
        if (!empty($request['name'])) {
            $request['name'] = trim($request['name']);
        }
        if (!empty($request['last_name'])) {
            $request['last_name'] = trim($request['last_name']);
        }
        if (!empty($request['password'])) {
            if( is_array($request['password']) ) {
                $request['password'] = trim($request['password'][1]);   // idk
            }
            $request['password'] = trim($request['password']);
        }


        $input = $request->toArray();
        //$request['from_postRegister']=true;

       $this->register($input, $test_mode);


        $status= 'Check your email for a note from us and get ready to earn some game-changing income.';

        return ApiUtils::response_success(['message'=> $status], $this->statusCreated);

    }

    public function userRegister(Request $request, $test_mode = false) {



        $this->validate($request, [
            'name' => 'required',
            'last_name'=>'required',
            'code' => 'required',
            'number' => 'required|min:10|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
            'email' => 'required|email|unique:user',
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'c_password' => 'required|same:password',
            'age' => 'accepted',
            'promo_code' => 'nullable|exists:promo_code,code',
        ]);

        if(!$this->validate_number($request)){
            return ApiUtils::response_fail_mobile_num(['number'=>['Mobile number is invalid']],"The given data was invalid.");         
         }  

        if (!empty($request['email'])) {
            $request['email'] = trim($request['email']);
        }
        if (!empty($request['name'])) {
            $request['name'] = trim($request['name']);
        }
        if (!empty($request['last_name'])) {
            $request['last_name'] = trim($request['last_name']);
        }
        if (!empty($request['password'])) {
            if( is_array($request['password']) ) {
                $request['password'] = trim($request['password'][1]);   // idk
            }
            $request['password'] = trim($request['password']);
        }


        $input = $request->toArray();
        //$request['from_postRegister']=true;

        $this->registerUser($input, $test_mode);


        $status= '';

        return ApiUtils::response_success(['message'=> $status], $this->statusCreated);

    }

    public function getUser() {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    private function register($user_data,$test_mode = false) {

     

        $usre_data['accepted_terms']=null;
        if (isset($user_data['terms_agree']) || isset($user_data['from_facebook'])){
            if ($user_data['terms_agree'] =='on' || isset($user_data['from_facebook']) ){
                $user_data['accepted_terms']=date('Y-m-d H:i:s');
            }
        }

        if ( !isset($user_data['content_level'])
            || (isset($user_data['content_level'])
                && !in_array($user_data['content_level'] ,WhiteLabel::config('user')->content_levels)))
        {
            $user_data['content_level'] = 'NO RESTRICTION';
            if (isset($user_data['all_ages']) || isset($user_data['from_facebook']))
            {
                if (isset($user_data['from_facebook']) || $user_data['all_ages'] == 'on')
                {
                    $user_data['content_level'] = 'ALL AGES ONLY';
                }
            }
        }
     

        $this->create_user = $this->create($user_data);

        $country  = Country_all::where('code2', $user_data['code'])->first();

        $in= [
            'user_id'=>$this->create_user->id,
            'number'=> $user_data['number'],
            'code2' => $user_data['code'],
            'prefix' => $country->prefix
        ];
        $user_mobile_num = UserMobileNum::create($in);
        if (!$this->create_user)
        {
            return ['internal' => 'Sorry, an error occurred creating account'];
        }
        if (!$user_mobile_num)
        {
            return ['internal' => 'Sorry, an error occurred adding phone number to account'];
        }
        $verifyUser = VerifyUser::create([
            'user_id' => $this->create_user->id,
            'token' => sha1(time()),
        ]);

        Mail::to($this->create_user->email, $this->create_user->UserProfile()->first()->name)->send(new RegisterSuccessEmail($this->create_user));

        $this->create_user->save();

        return null;
    }

    private function registerUser($user_data,$test_mode = false) {



        $usre_data['accepted_terms']=null;
        if (isset($user_data['terms_agree']) || isset($user_data['from_facebook'])){
            if ($user_data['terms_agree'] =='on' || isset($user_data['from_facebook']) ){
                $user_data['accepted_terms']=date('Y-m-d H:i:s');
            }
        }

        if ( !isset($user_data['content_level'])
            || (isset($user_data['content_level'])
                && !in_array($user_data['content_level'] ,WhiteLabel::config('user')->content_levels)))
        {
            $user_data['content_level'] = 'NO RESTRICTION';
            if (isset($user_data['all_ages']) || isset($user_data['from_facebook']))
            {
                if (isset($user_data['from_facebook']) || $user_data['all_ages'] == 'on')
                {
                    $user_data['content_level'] = 'ALL AGES ONLY';
                }
            }
        }


        $this->create_user = $this->createUser($user_data);

        $country  = Country_all::where('code2', $user_data['code'])->first();

        $in= [
            'user_id'=>$this->create_user->id,
            'number'=> $user_data['number'],
            'code2' => $user_data['code'],
            'prefix' => $country->prefix
        ];
        $user_mobile_num = UserMobileNum::create($in);
        if (!$this->create_user)
        {
            return ['internal' => 'Sorry, an error occurred creating account'];
        }
        if (!$user_mobile_num)
        {
            return ['internal' => 'Sorry, an error occurred adding phone number to account'];
        }
        $verifyUser = VerifyUser::create([
            'user_id' => $this->create_user->id,
            'token' => sha1(time()),
        ]);
        
        EmailUtils::send_to_user_when_register($this->create_user);
        EmailUtils::send_to_clients_credits_offer($this->create_user);

        $this->create_user->save();

        return null;
    }

    protected function create(array $data)
    {

        $user = new User();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = WhiteLabel::config('user')->roles['Model'];

        if(isset($data['referral'])){
            $user->referred_by = $data['referral'];
        }
        $user->email_validated = true;
        $user->save();

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->name = "Subscription";
        $subscription->save();

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->type = "SNAPCHAT";
        $subscription->status = false;
        $subscription->name = "Snapchat Subscription";
        $subscription->save();

        $profile = new UserProfile();
        $profile->name = $data['name'];

        $profile->last_name = $data['last_name'];
        $profile->display_name = trim($data['display_name']);

        $profile->profile_link = WebUtils::seoUrl($data['display_name']);


        /*if(isset($data['social_link_one'])){
            $profile->social_link_one = $data['social_link_one'];
        }
        if(isset($data['social_link_two'])){
            $profile->social_link_two = $data['social_link_two'];
        }*/
        $profile->user()->associate($user);
        $profile->save();

        $credential = new UserCredentials();
        $credential->user()->associate($user);
        $credential->save();

        $work = new UserWorks();
        $work->user()->associate($user);
        $work->save();

        $language = new UserLanguages();
        $language->languages_id = 43;
        $language->user()->associate($user);
        $language->save();

        for ($i = 1; $i <= 3; $i ++){
            $userService = new UserService();
            $userService->user()->associate($user);
            $userService->service_id = $i;

            if ($i == 1) {
                $userService->min_duration=5;
                $userService->rate=2;
            }
            elseif ($i == 3) {                
                $userService->min_duration=5;
                $userService->rate=5;
            }

            $userService->save();
        }

        $user->categories()->sync($data['categories']);
        $user->save();
        return $user;


    }

    protected function createUser(array $data)
    {

        $user = new User();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = WhiteLabel::config('user')->roles['User'];

        $user->credits = 10;
        $user->email_validated = true;

        if(isset($data['promo_code'])){
            $promo = PromoCode::where('code', $data['promo_code'])->where('status', 1)->first();
            if($promo){
                $user->credits += $promo->credits;
                $user->promo_code_id = $promo->id;
                $promo->times_used += 1;

                if($promo->times_used == $promo->max_use){
                    $promo->status = 0;
                }
                $promo->save();
            }
        }


        $user->save();

        $profile = new UserProfile();
        $profile->name = $data['name'];

        $profile->last_name = $data['last_name'];
        $display_name = WebUtils::seoUrl($data['name']."-".$data['last_name']."-".uniqid());
        $profile->display_name = $display_name;

        $profile->profile_link = $display_name;


        $profile->user()->associate($user);
        $profile->save();



        $creditLog = new UserCreditLog();
        $creditLog->user_id = $user->id;
        $creditLog->credits = $user->credits;
        $creditLog->action = "Free Credits";
        $creditLog->save();

        return $user;


    }
    private function validate_number($request){

        $country  = Country_all::where('code2', $request->input('code'))->first();
        $number = $country->prefix.$request->input('number');
        $check_number = TwilioUtils::is_valid_number($number,$request->input('code'));      
        return $check_number; 
         
    }

}
