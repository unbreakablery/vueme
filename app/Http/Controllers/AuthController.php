<?php
namespace App\Http\Controllers;
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
use App\Models\UserReferral;
use App\Services\CacheUtils;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;

use Illuminate\Mail\Message;
use App\Models\UserCreditLog;

use App\Models\UserHoroscope;
use App\Models\UserLanguages;
use App\Models\UserMobileNum;
use App\Services\TwilioUtils;
use App\Models\UserCredentials;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\UserFavoritePsychics;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Cast\Object_;
use App\Mail\RegisterSuccessEmail;
use App\Models\UserDocument;
use Illuminate\Http\UploadedFile;
use App\Models\File;
use IDAnalyzer\Vault;
use IDAnalyzer\CoreAPI;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\v1\GenericResource;
use Response;

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
            //'name' => 'required',
           // 'last_name'=>'required',
            'code' => 'required',
            //'number'  => WebUtils::verifyPhone([(object)['number' => $request->input('number')]]) ? 'required|min:10|numeric|regex:/[0-9]{10}/' : 'required|min:10|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
            'email' => ['required', 'email', 'unique:user',  new \App\Rules\emailValidator(), 'bail'],
            //'categories' => 'required|array|min:1|max:4',
            //'tools' => 'required|array|min:1|max:3',
            //'specialties' => 'required|array|min:1|max:4',
            //'styles' => 'required|array|min:1|max:1',
            /*'display_name' => 'required|min:3|unique:user_profile|regex:/^[a-zA-Z0-9_-]*$/',*/
            'display_name' => "required|min:3|max:46|unique:user_profile|regex:/^[a-z\d\-_.\s]+$/i",
            /*'referral' => 'required',*/
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'age' => 'accepted',
        ]);
      /*if(!WebUtils::verifyIp($request)){
            return ApiUtils::response_fail_mobile_num(['spam'=>['Your signup could not be completed. Please contact support with error O1C7JM']],"The given data was invalid.");
        }*/

       /* if(!WebUtils::verifyRecaptcha($request)){
            return ApiUtils::response_fail_mobile_num(['spam'=>['Contact our support team for assistance']],"The given data was invalid.");
        }*/
  
        

        if (!empty($request['email'])) {
            $request['email'] = trim($request['email']);
        }
      /*  if (!empty($request['name'])) {
            $request['name'] = trim($request['name']);
        }
        if (!empty($request['last_name'])) {
            $request['last_name'] = trim($request['last_name']);
        }*/
        if (!empty($request['password'])) {
            if( is_array($request['password']) ) {
                $request['password'] = trim($request['password'][1]);   // idk
            }
            $request['password'] = trim($request['password']);
        }


        $input = $request->toArray();
        //$request['from_postRegister']=true;

       $this->register($input, $test_mode);

       $request->session()->put('redirect_url', route('psychic_profile'));//to redirect same page user  

       $request->merge([
            'email' => trim($request->email),
            'password' => trim($request->password),
        ]);

        if(Auth::attempt($request->only('email', 'password'), true))
         return ApiUtils::response_success(['message'=> 'login'], $this->statusCreated);


        $status= 'Check your email for a note from us and get ready to earn some game-changing income.';

        return ApiUtils::response_success(['message'=> $status], $this->statusCreated);

    }   
    public function userRegister(Request $request, $test_mode = false) {

        $this->validate($request, [
            'code' => 'required',
            'number' => 'required|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
            'email' => ['required', 'email', 'unique:user',  new \App\Rules\emailValidator(), 'bail'],
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|confirmed',
            'age' => 'accepted',
            'promo_code' => 'nullable|exists:promo_code,code',
            'password_confirmation' => 'required'
        ]);


        // if(!WebUtils::verifyIp($request)){
        //     return ApiUtils::response_fail_mobile_num(['spam'=>['Your signup could not be completed. Please contact support with error O1C7JM']],"The given data was invalid.");
        // }


        // if(!WebUtils::verifyRecaptcha($request)){
        //     return ApiUtils::response_fail_mobile_num(['spam'=>['Contact our support team for assistance']],"The given data was invalid.");
        // }


        // if(!$this->validate_number($request)){
        //     return ApiUtils::response_fail_mobile_num(['number'=>['Mobile number is invalid']],"The given data was invalid.");         
        //  }  
        if (!empty($request['email'])) {
            $request['email'] = trim($request['email']);
        }
        if (!empty($request['name'])) {
            $request['name'] = trim($request['name']);
        }

        if (!empty($request['password'])) {
            if( is_array($request['password']) ) {
                $request['password'] = trim($request['password'][1]);   // idk
            }
            $request['password'] = trim($request['password']);
        }


        $input = $request->toArray();
        //$request['from_postRegister']=true;
        $input['join_id'] = session('join_id');


        $this->registerUser($input, $test_mode);


        $status= '';

        $request->merge([
            'email' => trim($request->email),
            'password' => trim($request->password),
        ]);
  
        $request->session()->put('redirect_url', session()->previousUrl());//to redirect same page user  
        
        if(Auth::attempt($request->only('email', 'password')))
         return ApiUtils::response_success(['message'=> 'login'], $this->statusCreated);

        return ApiUtils::response_success(['message'=> $status], $this->statusCreated);

    }

    public function userHoroscopeRegister(Request $request, $test_mode = false) {

        $status= '';
        $this->validate($request, [
            'age' => 'accepted',
            'name' => 'required',
            'birth_date' => 'required',
        ]);
        


        // if(!WebUtils::verifyRecaptcha($request)){
        //     return ApiUtils::response_fail_mobile_num(['spam'=>['Contact our support team for assistance']],"The given data was invalid.");
        // }

        
      

        if (!empty($request['email'])) {

            $this->validate($request, [
                'email' => ['required', 'email', 'unique:user_horoscope',  'bail'],
            ]);

            $request['email'] = trim($request['email']);



        }


        if (!empty($request['number'])) {

            $this->validate($request, [
                'number' => 'required|numeric|regex:/[0-9]{10}/|unique:user_horoscope',
            ]);
            if(!$this->validate_number($request)){
                return ApiUtils::response_fail_mobile_num(['number'=>['Mobile number is invalid']],"The given data was invalid.");         
             }  

        }

        if ( (empty($request['email'])) && (empty($request['number'])) ) {


            return ApiUtils::response_fail_mobile_num(['age'=>['Oops, email or mobile required']],"The given data was invalid.");   
                  
            
        }


        
        if (!empty($request['name'])) {
            $request['name'] = trim($request['name']);
        }


        // $request['accepted_terms']=null;
        // if (isset($request['terms_agree']) || isset($request['from_facebook'])){
        //     if ($request['terms_agree'] =='on' || isset($request['from_facebook']) ){
        //         $request['accepted_terms']=date('Y-m-d H:i:s');
        //     }
        // }
        if($request['birth_date']){
            $date = new \DateTime($request['birth_date']);
            $birth_date  = $date->format('Y-m-d');
        }


        $country  = Country_all::where('id', $request['code'])->first();
        $country_code = $country->prefix;


        $user = new UserHoroscope();
        $user->email = $request['email'];
        $user->birth_date = $birth_date;
        $user->name = $request['name'];
        $user->country_code = $country_code;
        $user->number = $request['number'];
        $user->email_validated = true;

        if ($user->save())
        return response()->json(['success' => $user], $this->statusCreated);
          
        
        
        return response()->json(['message' => 'error'], $this->successStatus);
        
        
        
        

    }

    public function getUser() {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    private function register($user_data,$test_mode = false) {

     

        $user_data['accepted_terms']=null;
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
        if (!$this->create_user)
        {
            return ['internal' => 'Sorry, an error occurred creating account'];
        }
        $verifyUser = VerifyUser::create([
            'user_id' => $this->create_user->id,
            'token' => sha1(time()),
        ]);

        Mail::to($this->create_user->email, $this->create_user->UserProfile()->first()->name)->send(new RegisterSuccessEmail($this->create_user));

        
        $this->create_user->save();
        $this->create_user->streaming_key = "STRKRS-" . base64_encode($this->create_user->id);
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

        $country  = Country_all::where('id', $user_data['code'])->first();

        $in= [
            'user_id'=>$this->create_user->id,
            'number'=> $user_data['number'],
            'code2' => $country->code2,
            'prefix' => $country->prefix
        ];
        $user_mobile_num = $in['number'] !== null ? UserMobileNum::create($in) : '';
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
        //EmailUtils::send_to_clients_credits_offer($this->create_user);

        $user  = $this->create_user->save();




       

        return null;
    }

    protected function create(array $data)
    {

        $user = new User();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = WhiteLabel::config('user')->roles['Model'];

       /* if(isset($data['referral'])){
            $user->referred_by = $data['referral'];
        }*/
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


        for ($i = 1; $i <= 2; $i ++){
            $userService = new UserService();
            $userService->user()->associate($user);
            $userService->service_id = $i;

            
                $userService->min_duration=5;
                $userService->rate=2;
           
           

            $userService->save();
        }

        $user->categories()->sync($data['categories']);
        $user->specialties()->sync($data['specialties']);
        $user->tools()->sync($data['tools']);
        $user->styles()->sync($data['styles']);
        $user->save();
        return $user;


    }

    protected function createUser(array $data)
    {

        $user = new User();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = WhiteLabel::config('user')->roles['User'];

        //$user->credits = 10;
        $user->email_validated = true;
        $user->referred_by_user = $data['join_id'];

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

        $username = explode('@', $data['email']);
        $username = $username[0];

        $profile = new UserProfile();
        $profile->name = $username;

        //$profile->last_name = $data['last_name'];
        $display_name = WebUtils::seoUrl($username."-".uniqid());
        $profile->display_name = $display_name;

        $profile->profile_link = $display_name;


        $profile->user()->associate($user);
        $profile->save();


        if($user->referred_by_user){

            $user_referral = new UserReferral();
            $user_referral->referral_email = $user->email;
            $user_referral->user_id = $user->referred_by_user;
            $user_referral->referral_id = $user->id;
            $user_referral->action = 'Invite Accepted';
            $user_referral->save();

            $user_favorite = new UserFavoritePsychics();
            $user_favorite->user_id = $user->id;
            $user_favorite->psychic_id = $user->referred_by_user;
            $user_favorite->save();


            
        }



        /*$creditLog = new UserCreditLog();
        $creditLog->user_id = $user->id;
        $creditLog->credits = $user->credits;
        $creditLog->action = "Free Credits";
        $creditLog->save();*/

        return $user;


    }
    private function validate_number($request){

        $country  = Country_all::where('id', $request->input('code'))->first();
        $number = $country->prefix.$request->input('number');
        $check_number = WebUtils::verifyPhone([(object)['number' => $request->input('number')]]) ? true : TwilioUtils::is_valid_number($number,$request->input('code'));      
        return $check_number; 
         
    }

    public function verifyCode(Request $request)
    {

        $validator = $request->validate([
            'code' => 'required',
        ]);


        $user = Auth::user();
        $phoneNumber = $user->user_mobile_nums()->first();

        if($request->input('code') == $phoneNumber->verification_code)
        {
            $phoneNumber->validated = true;
            $phoneNumber->verification_code = null;
            $phoneNumber->save();
            return response()->json(['message'=> 'Phone verified', "role"=>$user->role_id], 200);
        }
        else
        {
          // return ApiUtils::response_fail(['message'=> 'Invalid verification code'], 400);
          return Response::json(['errors' => ['code' => ['Invalid verification code']]], 400);
                 

        }
    }
    public function sendSmsCode()
    {
        $user = Auth::user();
        $mobile = $user->user_mobile_nums()->first();

        if($mobile){
            $code = rand(1000, 9999); //generate random code
            $mobile->verification_code = $code; //save code
            $mobile->save();

            TwilioUtils::send_verification_sms($mobile,$user);
            return response()->json(['message'=> 'We have texted a verification code to +'.$mobile->code2.$mobile->number], 200);

        }else{
            return ApiUtils::response_fail(['message'=> 'Phone number unavailable.'], 400);

        }
    }

    public function validateStep1(Request $request, $test_mode = false) {

        $this->validate($request, [
            // 'name' => 'required',
            // 'last_name'=>'required',
            // 'code' => 'required',
            // 'number' => 'required|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
            'email' => ['required', 'email', 'unique:user',  new \App\Rules\emailValidator(), 'bail'],
            'display_name' => "required|min:3|max:46|unique:user_profile|regex:/^[a-z\d\-_.\s]+$/i",
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'c_password' => 'required|same:password',
            'age' => 'accepted',
        ]);

        // if(!WebUtils::verifyIp($request)){
        //     return ApiUtils::response_fail_mobile_num(['spam'=>['Your signup could not be completed. Please contact support with error O1C7JM']],"The given data was invalid.");
        // }

        // if(!$this->validate_number($request)){
        //     return ApiUtils::response_fail_mobile_num(['number'=>['Mobile number is invalid']],"The given data was invalid.");         
        //  }    
        $register = $this->postRegister($request);
        $status= 'Step 1';

        return ApiUtils::response_success(['message'=> $status], $this->statusCreated);
      
    }
    
    
    public function validateStep2(Request $request, $test_mode = false) {
        $user = Auth::user();
        $this->validate($request, [
            'categories' => 'required|array|min:1|max:4',
            'name' => 'required',
            'last_name'=>'required',
            'number'  => WebUtils::verifyPhone([(object)['number' => $request->input('number')]]) ? 'required|min:10|numeric|regex:/[0-9]{10}/' : 'required|min:10|numeric|regex:/[0-9]{10}/|unique:user_mobile_num',
            'governmentIssuedFile' => 'required|mimes:jpeg,bmp,png,jpg',
            'faceFile' => 'required|mimes:jpeg,bmp,png,jpg'
             ]);
        //--------------------------------------------------------   
        $data = $request->toArray();
        $user = Auth::user();
        if (!$user) {
            return redirect("/");
        }
        if(!$this->validate_number($request)){
            return ApiUtils::response_fail_mobile_num(['number'=>['Mobile number is invalid']],"The given data was invalid.");         
        }  
        $country  = Country_all::where('id', $data['code'])->first();
        $in= [
            'user_id'=>$user->id,
            'number'=> $data['number'],
            'code2' => $country->code2,
            'prefix' => $country->prefix
        ];
        $user_mobile_num = UserMobileNum::create($in);
        if (!$user_mobile_num)
        {
            return ['internal' => 'Sorry, an error occurred adding phone number to account'];
        }
        $user->categories()->sync($data['categories']);
        if(isset($data['referral'])){
            $user->referred_by = $data['referral'];
        }
        $profile = $user->userProfile;
        $profile->name = $data['name'];        
        $profile->last_name = $data['last_name'];    
        $profile->license_checked = true;  
        $profile->save();
        $user->streaming_key = "STRKRS-" . base64_encode($user->id);
        //-------------------------------------------------
        $mobile = $user->user_mobile_nums()->first();

        if($mobile){
            $code = rand(1000, 9999); //generate random code
            $mobile->verification_code = $code; //save code
            $mobile->save();
            if(!WebUtils::verifyPhone([(object)['number' => $request->input('number')]]))
            TwilioUtils::send_verification_sms($mobile,$user);
        }
        //-------------------------------------------------
        $user->save();  
        //--------------------------------------------------------
        $createDocument = function($type, $userId, UploadedFile $uploadedFile = null, $noSaveRemote = false){

            $document = new UserDocument();
            $document->type = $type;
            $document->user_id = $userId;
            $document->save();
   
            $file = new File();
            if(!$noSaveRemote)
             $file->saveRemote($uploadedFile);
            else $file->setData($uploadedFile, false); 
            $document->file()->save($file);
            return $document;

         };
//--------------------------------------------------------------------------------------------------------------
     //    $coreapi = new CoreAPI(env('idanalyzer_key'), 'US');
     //    $coreapi->enableAuthentication(true, '2');
        /* $user_exists = User::where(['email'=>$request->email])->first();
         if($user_exists == null)   {
         $input = $request->toArray();
         $input['join_id'] = session('join_id');         
         $status= ''; 
         $request->session()->put('redirect_url', session()->previousUrl());//to redirect same page user  
         }*/
         $user = Auth::user();
         if (!$user) {
             return redirect("/");
         }
         try {
            if($user->governmentIssuedDocument)$user->governmentIssuedDocument->delete();
             $a = $createDocument('Government Issued', $user->id, $request->governmentIssuedFile);
             if($user->faceDocument)$user->faceDocument->delete();
             $b = $createDocument('Face picture', $user->id, $request->faceFile);
             $status= 'Step 2 validated';
             return ApiUtils::response_success(['message'=> $status], $this->statusCreated);
             //$result = $coreapi->scan($governmentIssuedFilePath, "", $faceFilePath);
        
             /* if(isset($result["vaultid"])){
               if(!isset($result['face']['isIdentical']))   
                return Response::json(['errors' => ['faceFile' => ['Bad picture']]], 400);
               $data = array_merge(['vault' => $result["vaultid"], 'authentication_score' => $result['authentication']['score'], 'validate_face_picture' => $result['face']['isIdentical']], $result['result']);
               if(isset($data['age']) && $data['age'] < 18)
                   return Response::json(['errors' => ['Age' => ['You must be at least 18 years old to register on this site.']]], 400);
                if($request->governmentIssuedFile){
                if($user->governmentIssuedDocument)$user->governmentIssuedDocument->delete();
                $license = $createDocument('Government Issued', $user->id, $request->governmentIssuedFile);
               }
               else $license = $user->governmentIssuedDocument;
               
               DB::table('user_document')->where('id', $license->id)->update($data);

               if($request->faceFile){
                if($user->faceDocument)$user->faceDocument->delete();
                $createDocument('Face picture', $user->id, $request->faceFile);
               }   */          
            //  if($license->authentication_score <= 0.3)
             //   return Response::json(['errors' => ['governmentIssuedFile' => ['The document uploaded is fake.']]], 400);
            //    else 
                 //  if(!$result['face']['isIdentical'])
               //     return Response::json(['errors' => ['faceFile' => ['The photo looks different to the photo on document.']]], 400);
                 //   return new GenericResource(UserDocument::find($license->id), ['id', 'documentNumber', 'firstName', 'lastName', 'dob', 'sex', 'issued', 'expiry', 'issuerOrg_region_full', 'issuerOrg_full', 'address1', 'address2', 'postcode', 'nationality_iso2']);       
           //  }
           //  else if(isset($result['error'])) return Response::json(['errors' => ['governmentIssuedFile' => [$result['error']['message']]]], 400);
         } catch (Exception $e) {
             return Response::json(['errors' => ['governmentIssuedFile' => [$e->getMessage()]]], 400);
         }        

        //--------------------------------------------------------

        $status= 'Step 2 validated';
        return ApiUtils::response_success(['message'=> $status], $this->statusCreated);
    }  
}
