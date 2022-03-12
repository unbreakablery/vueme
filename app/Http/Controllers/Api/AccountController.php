<?php

namespace App\Http\Controllers\Api;

use Pusher;
use Exception;
use Carbon\Carbon;
use AuthController;
use App\Models\User;
use App\Models\Order;
use App\Billing\gwapi;
use App\Models\UserWorks;
use App\Models\VerifyUser;
use App\Services\ApiUtils;
use App\Services\WebUtils;
use App\Models\Transaction;
use App\Models\UserProfile;
use App\Models\Subscription;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use App\Models\UserCreditLog;
use App\Models\UserLanguages;
use App\Models\UserMobileNum;
use App\Services\TwilioUtils;
use Illuminate\Http\Response;
use App\Models\PromoBuyCredit;
use App\Services\BillingUtils;

use App\Models\UserBillerEdata;
use App\Models\UserCredentials;
use Illuminate\Validation\Rule;
use App\Models\UserSubscription;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;
use App\Services\NotificationsInAppUtils;
use phpDocumentor\Reflection\Types\Self_;
use App\Http\Resources\v1\GenericResource;
use App\Http\Resources\v1\UserBasicResource;
use App\Http\Resources\v1\UserProfileBasicResource;
use App\Services\ProfileUploadUtils as UploadUtils;
use App\Http\Resources\v1\GenericResourceCollection;

class AccountController extends Controller
{


    const BILLERTYPEDEPOSITACCOUNT = 'DEPOSIT';
    const BILLERTYPECREDIT = 'CREDIT';
    const BILLERTYPEDEBIT = 'DEBIT';
    const BILLERBYCREDIT = 'BUY_CREDIT';
    const BILLERS = [self::BILLERTYPEDEPOSITACCOUNT, self::BILLERTYPECREDIT, self::BILLERTYPEDEBIT,self::BILLERBYCREDIT];

    const BUYCREDIT = 'BUY_CREDIT';
    const SUBSCRIPTION = 'SUBSCRIPTION';
    const TRANSACTIONACTIONADDANDBUYCREDIT = 'ADD_CARD_AND_BUY_CREDIT';
    const TRANSACTIONACTIONADDANDSUBSCRIBE = 'ADD_CARD_AND_SUBSCRIBE';
    const TRANSACTIONACTIONADDCARD = 'ADD_CARD';
    const TRANSACTIONACTIONADD_DEPOSIT_ACCOUNT = 'ADD_DEPOSIT_ACCOUNT';
   
    



    const ORDERSTATUSREJECT = 'REJECT';
    const ORDERSTATUSAPPROVED = 'APPROVED';
    const ORDERSTATUSPENDING = 'PENDING';


    public function __construct(Guard $auth)
    {        
        $this->middleware('auth:api');   
        $this->auth = $auth;
    }

    public function account()
    {
        //Log::debug("In account\n\n");


        if (!Auth::user()) {
            return $this->response_fail();
        }

        $user = Auth::user();

        if ($user->role_id == 1) {

            $star = $user->star;
            $star->load('media');

            $account = [
                'id' => $star->id,
                'profile_name' => $star->profile_name,
                'email' => $user->email,
                'country_code' => $user->country_code,
                'available' => explode(',', $star->available),
                'services' => explode(',', $star->services),
                'profile_image' => $this->_star_profile_image($star),
                'profile_url' => $star->full_url,
                'referral_url' => $star->full_referral_url,
                'earnings' => Accounting::payouts('star')->get_pay_period($user->star_id),
                'account_type' => 'STAR',
                'rates' => $this->_star_rates_json($star->id),
                'onboarding_flags' => implode(',', $star->launch_checklist),
                'phone_number' => \WebUtils::format_phone_number($star->number, true)
            ];
            $mature_type = $star->star_chat_filter_id;
            switch ($mature_type) {
                case 1:
                    $account['restricted'] = 1;
                    break;
                case 2:
                    $account['mature'] = 0;
                    break;
                case 3:
                    $account['mature'] = 1;
            }
        } else {

            $phone_number = UserMobileNum::where('user_id', '=', $user->id)
                ->where('active', '=', 'Y')
                ->orderBy('id', 'desc')
                ->first();


            $phone_number = $user->user_mobile_nums()->where('active', '=', 'Y')
                ->orderBy('id', 'desc')
                ->first();


            if ($phone_number) {
                $phone_number_validated = $phone_number->validated == 'Y';
                $phone_number = ApiUtils::format_phone_number($phone_number->number, true);
            } else {
                $phone_number = null;
                $phone_number_validated = false;
            }

            if ($user->display_name == "") {
                $show_name = $user->username;
            } else {
                $show_name = $user->display_name;
            }
            $mature = 0;
            $auto_renew = false;
            $card_type = $last_four = $exp_date = '123';

            $account = [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'display_name' => $show_name,
                'country_code' => $user->country_code,
                'credits' => $user->credits,
                'account_type' => 'USER',
                /* 'categories' => $this->_user_categories_json(),*/
                'phone_number' => $phone_number,
                'phone_number_validated' => $phone_number_validated,
                'mature' => $mature,
                'last_four' => $last_four,
                'exp_date' => $exp_date,
                'card_type' => $card_type,
                'auto_renew' => $auto_renew,
                /* 'unread_messages' => message::get_unread('USER', Auth::user()->id)*/
            ];
        }

        //user_site_visit_log::visit(WhiteLabel::site_id_from_uri());

        $user->app_used_at = date('Y-m-d H:i:s');
        $user->save();

        return response()->json(['success' => ['account' => $account]], 200);
        //return $this->response_success(['account' => $account]);
    }

    public function profile()
    {
        if (!Auth::user()) {
            //return $this->response_fail();
        }

        $user = Auth::user();

        if(count($user->languages()->get())<=0){
        
            $newcredential = new UserLanguages();
            $newcredential->languages_id = 43;
            $newcredential->user()->associate($user);
            $newcredential->save();

        }

        if(count($user->works()->get())<=0){

            $newcredential = new UserWorks();
            $newcredential->user()->associate($user);
            $newcredential->save();
            
        }

        return response()->json(['success' => ['profile' => new UserBasicResource($user)]], 200);    

        

        /*$user->app_used_at = date('Y-m-d H:i:s');
        $user->save();*/

        // return response()->json(['success' => ['profile' => new UserBasicResource($user)]], 200);
    }

    public function saveProfile(Request $request)
    {


        // save user profile
        if (!Auth::user()) {
            return $this->response_fail();
        }

       if($request->tab == 1)
       $validator = $request->validate([
     
            
            'profile.name' => 'required|max:50',
            'profile.last_name' => 'required|max:50',
            //'profile.birth_date' => 'required|date|max:50|before:18 years ago',
            //'profile.gender' => 'required|max:50',
            //'languages.*.languages_id' => ['required','min:1', 'distinct'], 
            'profile.display_name' => ['required',"regex:/^[a-z\d\-_.\s]+$/i", 'min:3', 'max:46', Rule::unique('user_profile', 'display_name')->ignore($request->input('id'), 'user_id')], // unique:user_profile
            'phone_numbers.*.code2' => 'required',
            'phone_numbers.*.number' => 'required|regex:/[0-9]{5,15}/',
            // 'profile.timezone' => 'required',
            


        ]);
        else if($request->tab == 2)
        $validator =  $request->validate([  

            'categories' => 'required|array|min:1|max:2000',

         ]);
        else if($request->tab == 3){
        $validationregex ="|regex:/^[a-z\d,.!'’?\-_\s]+$/i";
        if($request["profile"]["description"] ==""){
            $validationregex="";
        }
        $validator =  $request->validate([  

            //'profile.years_experience' => 'required|integer|min:1',
            //'profile.tagline' => "required|min:20|max:50|regex:/^[a-z\d,.!'’?\-_\s]+$/i",
            //'profile.elevator_pitch' => "required|min:100|max:160|regex:/^[a-z\d,.!'’?\-_\s]+$/i",
            'profile.description' => "required|max:400".$validationregex,
            //'specialties' => 'required|array|min:1|max:4',
            'profile.profile_link' => ['required',"regex:/^[a-z\d\-_.\s]+$/i", 'min:3', 'max:46', Rule::unique('user_profile', 'profile_link')->ignore($request->input('id'), 'user_id')], // unique:user_profile
            //'tools' => 'required|array|max:3',
            //'styles' => 'required|array|max:1',

         ]);
        }

    


         


        //$birthdate = new \DateTime($request['profile.birth_date']);
        $user = User::find($request->input('id'));
        $user_profile = UserProfile::where('user_id', Auth::user()->id)->first();
        $user_phone = UserMobileNum::where('user_id', Auth::user()->id)->first();


        if($request->tab == 1) {
        $user_phone->number = $request->input('phone_numbers')[0]['number'];
        $user_phone->code2 = $request->input('phone_numbers')[0]['code2'];
        $user_profile->name = $request->input('profile.name');
        $user_profile->last_name = $request->input('profile.last_name');
        $user_profile->display_name = $request->input('profile.display_name'); 
        $user_profile->timezone = $request->input('profile.timezone'); 
        
        
        

        //if($request->input('Male') == '' || $request->input('Female') == '')
         //$user_profile->gender = $request->input('profile.gender');
        //$user_profile->birth_date = $birthdate->format('Y-m-d');
        //$user_profile->city = $request->input('profile.city');
        //$user_profile->state = $request->input('profile.state');
        //$user_profile->country = $request->input('profile.country');
        //$user_profile->timezone = $request->input('profile.timezone');


        

    }

    if($request->tab == 3) {
        
        $user_profile->profile_link = $request->input('profile.profile_link');
        // $user_profile->tagline = $request->input('profile.tagline');
        $user_profile->description = $request->input('profile.description');
        $user_profile->social_link_one = $request->input('profile.social_link_one');
        $user_profile->social_link_two = $request->input('profile.social_link_two');
        $user_profile->social_link_three = $request->input('profile.social_link_three');
       // $user_profile->elevator_pitch = $request->input('profile.elevator_pitch');
       // $user_profile->years_experience = $request->input('profile.years_experience');
    
        }


        $user_profile->touch();
        $user_profile->save();
        $user_phone->save();
        $user->save();



        if($request->tab == 2) {

        $categoriesIds = [];
        foreach ($request->input('categories') as $key => $cat){
            $categoriesIds[] = $cat['id'];
        }
        $user->categories()->sync($categoriesIds);
        $user->save();

      
        }
        
    
        
        return ApiUtils::response_success(new UserBasicResource($user));

    }

    public function saveUserProfile(Request $request)
    {

        // save user profile
        if (!Auth::user()) {
            return $this->response_fail();
        }
        //dd($request);
        $request->validate([
            'profile.name' => 'required|max:50',
            'profile.last_name' => 'required|max:50',
            'profile.birth_date' => 'required|date|max:50|before:18 years ago',
            // 'profile.gender' => 'required|max:50',
            /*'profile.display_name' => ['required', 'min:3', 'max:64', Rule::unique('user_profile', 'display_name')->ignore($request->input('id'), 'user_id'),], // unique:user_profile*/
            'phone_numbers.*.code2' => 'required',
            'phone_numbers.*.number' => 'required|regex:/[0-9]{5,15}/',
            'profile.timezone' => 'required',
            
            'profile.description' => 'nullable|max:2000'
        ]);


        $birthdate = new \DateTime($request->input('profile.birth_date'));
        $user = User::find($request->input('id'));
        $user_profile = UserProfile::where('user_id', Auth::user()->id)->first();
        $user_phone = UserMobileNum::where('user_id', Auth::user()->id)->first();

        /*$check_number = TwilioUtils::is_valid_number($user_phone->prefix.$user_phone->number,$user_phone->code2);
        if(!$check_number){
            return ApiUtils::response_fail_mobile_num(['phone_numbers.0.number'=>['Phone number is invalid']],"The given data was invalid.");
        }*/


        //$user->email = $request->input('email');
        $user_phone->number = $request->input('phone_numbers')[0]['number'];
        $user_phone->code2 = $request->input('phone_numbers')[0]['code2'];
        $user_profile->name = $request->input('profile.name');
        $user_profile->last_name = $request->input('profile.last_name');
        /*$user_profile->display_name = $request->input('profile.display_name');*/
        $user_profile->description = $request->input('profile.description');
        $user_profile->gender = $request->input('profile.gender');
        $user_profile->birth_date = $birthdate->format('Y-m-d');
        $user_profile->city = $request->input('profile.city');
        $user_profile->state = $request->input('profile.state');
        $user_profile->country = $request->input('profile.country');
        $user_profile->timezone = $request->input('profile.timezone'); 
        
        $user_profile->elevator_pitch = $request->input('profile.elevator_pitch');

        $user_profile->save();
        $user_phone->save();
        $user->save();

        return ApiUtils::response_success(new UserBasicResource($user));

    }

    public function deleteCredential($id, Request $request)
    {

        $user = Auth::user();

        $credential = $user->credentials()->find($id);

        if(!is_null($credential)){
            $credential->delete();
            return ApiUtils::response_success('Credential removed', 200);
        }

        return ApiUtils::response_fail(['message'=> 'Invalid credential ID'], 400);


    }

    public function deleteWork($id, Request $request)
    {

        $user = Auth::user();

        $work = $user->works()->find($id);

        if(!is_null($work)){
            $work->delete();
            return ApiUtils::response_success('Work removed', 200);
        }

        return ApiUtils::response_fail(['message'=> 'Invalid Work ID'], 400);


    }


    public function deleteLanguage($id, Request $request)
    {

        $user = Auth::user();

        $language = $user->languages()
            ->where('user_id', $user->id)
            ->where('languages_id', $id)
            ->first();

        if(!is_null($language)){
            $language->delete();
            return ApiUtils::response_success('Language removed', 200);
        }

        
        // return ApiUtils::response_fail(['message'=> 'Invalid Language ID'], 400);


    }

    public function saveProfileImages(Request $request)
    {
        if (!($user = Auth::user())) {
            return $this->response_fail();
        }
        $user_profile = UserProfile::where('user_id', $user->id)->first();

        try {
            // save user profile photo
            if ($request->hasFile('headshot')) {
                UploadUtils::uploadProfilePhoto($request, 'headshot', $user_profile);
                $profile = $user->userProfile()->first();
                return ApiUtils::response_success(['message' => 'Image saved', 'url' => $profile->haedshot_path], 200);
            }

            if ($request->hasFile('fullbody')) {
                UploadUtils::uploadProfilePhoto($request, 'fullbody', $user_profile);
                return ApiUtils::response_success('saved');
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex);
            return ApiUtils::response_success('error');
        }
    }

    // public function uploadProfileImage(Request $request)
    // {
    //     $this->validate($request, [
    //         'image'=> 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:20480',
    //     ]);

    //     $user = Auth::user();
    //     $profile = $user->userProfile()->first();

    //     $imageData = $request->image;

    //     if ($request->hasFile('image')) {
    //         UploadUtils::uploadProfilePhoto($request, 'image', $profile);
    //     }

    //     $profile = $user->userProfile()->first();


    //     return ApiUtils::response_success(['message' => 'Image saved', 'url' => $profile->haedshot_path], 200);

    // }

    // public function uploadProfileCover(Request $request)
    // {
    //     $this->validate($request, [
    //         'image'=> 'required|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:20480',
    //     ]);

    //     $user = Auth::user();
    //     $profile = $user->userProfile()->first();

    //     $imageData = $request->image;

    //     if ($request->hasFile('image')) {
    //         UploadUtils::uploadProfileCover($request, 'image', $profile);
    //     }


    //     return ApiUtils::response_success('Cover saved', 200);

    // }

    public function uploadProfileVideo(Request $request)
    {

      /*  $this->validate($request, [
            'file'=> 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/x-msvideo,video/x-ms-wmv,video/3gpp,video/ogg,video/webm, video/3gpp, application/vnd.apple.mpegurl,application/x-mpegurl',
        ]);
        dd($request);*/
        $user = Auth::user();
        $profile = $user->userProfile()->first();


        if ($request->hasFile('file')) {
            UploadUtils::uploadProfileVideo($request, 'file', $profile);
        }


        return ApiUtils::response_success(['message'=> 'Video saved', 
            'video_path'=> $profile->intro_video_path,
            'video_path_thumbnail'=> $profile->intro_video_thumbnail], 200);

    }

    public function uploadProfileAudio(Request $request)
    {


        /*$this->validate($request, [
            'file'=> 'required|mimetypes:audio/aac,audio/aifc,audio/x-aiff,audio/au,audio/x-au,audio/x-basic,application/x-winamp-playlist,audio/mpegurl,audio/mpeg-url,audio/playlist,audio/scpls,audio/x-scpls,audio/x-m4a,application/x-midi,audio/mid,audio/midi,audio/soundtrack,audio/mpeg,audio/x-mpeg,audio/x-mpeg-2,video/x-mpeg,video/x-mpeq2a,audio/mp3,audio/mpeg3,audio/mpg,audio/x-mp3,audio/x-mpeg,audio/x-mpeg3,audio/x-mpg',
        ]);*/

        $user = Auth::user();
        $profile = $user->userProfile()->first();


        if ($request->hasFile('file')) {
            UploadUtils::uploadProfileAudio($request, 'file', $profile);
        }


        return ApiUtils::response_success(['message'=> 'Video saved', 'audio_path'=> $profile->intro_audio_path], 200);

    }

    public function verifyUser($token)
    {

        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->email_validated) {
                $verifyUser->user->email_validated = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";

            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return ApiUtils::response_fail(['message' => 'Sorry your email cannot be identified.'], 404);
        }
        return ApiUtils::response_success(['success' => $status]);
    }

    public function resend(Request $request)
    {
        if ($request->user()->email_validated) {
            return ApiUtils::response_success(['success' => 'User already have verified email!']);

        } else {
            return ApiUtils::response_fail(['error' => 'resend']);
        }
    }

    public function card_data_request(Request $request)
    {

        $this->validate($request, [
            'cc_exp' => ['required','regex:/^0*([1-9]|1[0-2])[\/]([2-5][0-9]|60)/'],
            'cc_number' => ['required','numeric', 'digits_between:14,19','not_regex:/^3[47]\d{13,14}$/'],
            'cc_zip' => 'required|string|min:5|max:10',
            'cc_cvv' => 'required|numeric|digits_between:3,4',
            'first_name' => 'required',
            'last_name' => 'required',
            'billing_address' => 'string',
            'billing_address2' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'phone' => 'numeric',
        ]);


        $transactionType = "add_customer";
        $user = Auth::user();
        $customer = BillingUtils::checkCustomerVault($user->id);

        if ($customer > 0) {
            $transactionType = 'add_billing';
        }

        $ip_addr = WhiteLabel::getIpAddress();


        $billing_id = $user->id . '-' . rand(1, 999999999999);

        $status = null;
        $xid = null;
        $eci = null;
        $cavv = null;

        if (!empty($request->status)) {
            $status = trim($request->status);
        }
        if (!empty($request->xid)) {
            $xid = trim($request->xid);
        }
        if (!empty($request->eci)) {
            $eci = trim($request->eci);
        }
        if (!empty($request->cavv)) {
            $cavv = trim($request->cavv);
        }
        $data = [
            'cc_number' => $request->cc_number,
            'cc_exp' => $request->cc_exp,
            'cc_cvv' => $request->cc_cvv,
            'billing_id' => $billing_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'billing_address' => $request->billing_address,
            'billing_address2' => $request->billing_address2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->cc_zip,
            'country' => $request->country,
            'phone' => $request->phone,
            'transaction_type' => $transactionType,
            'ip' => $ip_addr,
            'status' => $status,
            'xid' => $xid,
            'eci' => $eci,
            'cavv' => $cavv,
        ];

        return $data;
    }

    public function save_card(Request $request)
    {   //dd($request);
        /*$test =|regex:/^((0[1-9])|(1[0-2]))\/(\d{2})$*/
        
        $data = $this->card_data_request($request);
        $amount = 1.00;
        $priority = 1;
       
        $user = Auth::user();

       

        $gw = new gwapi();  
        $gw->setLogin(BillingUtils::username(), BillingUtils::password());

        $gw->addCard($amount, $user->id, $data['cc_number'], $data['cc_exp'], $data['cc_cvv'],
            $data['billing_id'], $data['first_name'], $data['last_name'], $data['billing_address'],
            $data['billing_address2'], $data['city'], $data['state'], $data['zip'],
            $data['country'], $data['phone'], $data['transaction_type'], $priority, $data['ip'], $data['status'],
            $data['xid'], $data['eci'], $data['cavv']);

        $code = $gw->responses['response_code'];

        $card_type = self::BILLERTYPECREDIT;
        if ($request->card_type == self::BILLERTYPEDEBIT) {
            $card_type = self::BILLERTYPEDEBIT;
        }

        if ($code == "100") {

            $billing = new UserBillerEdata();
            $billing->billing_id = $data['billing_id'];
            $billing->test_mode = BillingUtils::get_mode();
            $billing->last_four = substr($data['cc_number'], -4);
            $billing->type = $card_type;
            UserBillerEdata::where('user_id', $user->id)->update(['preferred' => 0]);
            $billing->preferred = 1;
            $user->biller_edata()->save($billing);
            $billing->save();
            return ApiUtils::response_success(
                'Your card was added successfully.'
                , Response::HTTP_CREATED);

        } else {


            $responseText = $gw->responses['responsetext'];          
            $actionType = $gw->responses['type'];
            $avsCode = $gw->responses['avsresponse'];
            $result = $gw->responses['response'];
            $result_cvv = $gw->responses['cvvresponse'];

            $declineTransaction = new Transaction();            
            $declineTransaction->amount = $amount;
            $declineTransaction->action = self::TRANSACTIONACTIONADDCARD;
            $declineTransaction->result_text = $responseText;
            $declineTransaction->result_code = $code;
            $declineTransaction->result_avs = $avsCode;

            $declineTransaction->result = $result;
            $declineTransaction->result_type = $actionType;
            $declineTransaction->result_cvv = $result_cvv;
            $user->transactions()->save($declineTransaction);
            $declineTransaction->save();
            $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);

            return ApiUtils::response_fail($responseMessage,400);

        }


    }    
    public function save_card_payment(Request $request)
    {
        $gw = $this->card_validate($request);
        $user = Auth::user();
        $promo = $user->promo();
        $code = $gw->responses['response_code'];
        $amount = $request->credits;
        $promoAmount = 0;


        $result_promo = $this->validate_promo_code($request,false);

        if(isset($result_promo->error)){           
            return $result_promo;
        }else{
            if($result_promo != 0){
                $promoAmount = $result_promo['promoAmount'];
                $promoBuyCredit = $result_promo['promoBuyCredit'];
            }
        }

        $order = new Order();
        $order->type = self::BUYCREDIT;
        $order->credits = $amount;
        $order->status = self::ORDERSTATUSPENDING;
        $user->orders()->save($order);

        $responseText = $gw->responses['responsetext'];
        $actionType = $gw->responses['type'];
        $avsCode = $gw->responses['avsresponse'];
        $result = $gw->responses['response'];
        $result_cvv = $gw->responses['cvvresponse'];
        $data = $this->card_data_request($request);


        if ($code == "100") {

            $priority = 1;

            $gw->doSaleHybrid($user->id, $data['cc_number'], $data['cc_exp'], $data['cc_cvv'],
                $data['billing_id'], $data['first_name'], $data['last_name'], $data['billing_address'],
                $data['billing_address2'], $data['city'], $data['state'], $data['zip'],
                $data['country'], $data['phone'], $data['transaction_type'], $priority, $data['ip'],
                $amount, $order->id, null, $data['status'],
                $data['xid'], $data['eci'], $data['cavv']);


            $code = $gw->responses['response_code'];
            $responseText = $gw->responses['responsetext'];
            $actionType = $gw->responses['type'];
            $avsCode = $gw->responses['avsresponse'];
            $result = $gw->responses['response'];
            $result_cvv = $gw->responses['cvvresponse'];


            $card_type = self::BILLERTYPECREDIT;
            if ($request->card_type == self::BILLERTYPEDEBIT) {
                $card_type = self::BILLERTYPEDEBIT;
            }

            //All process is good
            if ($code == "100") {

                $order->status = self::ORDERSTATUSAPPROVED;
                $order->save();


                $billing = new UserBillerEdata();
                $billing->billing_id = $data['billing_id'];
                $billing->test_mode = BillingUtils::get_mode();
                $billing->last_four = substr($data['cc_number'], -4);
                $billing->type = $card_type;
                UserBillerEdata::where('user_id', $user->id)->update(['preferred' => 0]);
                $billing->preferred = 1;
                $user->biller_edata()->save($billing);
                $billing->save();

                $transaction = new Transaction();
                $transaction->order_id = $order->id;
                $transaction->billing_id = $billing->id;                
                $transaction->amount = $amount;
                $transaction->action = self::TRANSACTIONACTIONADDANDBUYCREDIT;
                $transaction->credits_old = $user->credits;
                $transaction->result_text = $responseText;
                $transaction->result_code = $code;
                $transaction->result_avs = $avsCode;
                $transaction->result = $result;
                $transaction->result_type = $actionType;
                $transaction->result_cvv = $result_cvv;
                $user->transactions()->save($transaction);
                $transaction->save();

                $user_credit_log = new UserCreditLog();
                $user_credit_log->site_id = WhiteLabel::site_id();
                $user_credit_log->credits = $amount;
                $user_credit_log->promo = $promo;
                if(isset($promoBuyCredit)){
                    $user_credit_log->promo_code = $promoBuyCredit->code;
                    $user_credit_log->promo_id = $promoBuyCredit->id;
                    $user_credit_log->promo_amount = $promoAmount;
                }
                $user_credit_log->action = self::BUYCREDIT;
                $user_credit_log->credits_old = $user->credits;
                $user->user_credit_logs()->save($user_credit_log);

                Log::info('From Accountcontroller save_card_payment() -- User credit old: $'.$user->credits. ' Amount: $'.$amount.' User ID:'.$user->id);
                $user->credits += $amount + $promo + $promoAmount;
                $user->save();
                Log::info('From Accountcontroller save_card_payment() -- User credit new: $'.$user->credits.' User ID:'.$user->id);


                //Todo send Email
                return ApiUtils::response_success(['msg'=> 'Purchase Confirmed.', 'purchase'=> $user_credit_log,'credits'=>$user->credits], Response::HTTP_CREATED);
                //return ApiUtils::response_success('Purchase Confirmed.', Response::HTTP_CREATED);

            } else {


                $order->status = self::ORDERSTATUSREJECT;
                $order->save();
                $declineTransaction = new Transaction();
                $declineTransaction->order_id = $order->id;                
                $declineTransaction->amount = 1.00;
                $declineTransaction->action = self::TRANSACTIONACTIONADDANDBUYCREDIT;
                $declineTransaction->credits_old = $user->credits;
                $declineTransaction->result_text = $responseText;
                $declineTransaction->result_code = $code;
                $declineTransaction->result_avs = $avsCode;
                $declineTransaction->result = $result;
                $declineTransaction->result_type = $actionType;
                $declineTransaction->result_cvv = $result_cvv;
                $user->transactions()->save($declineTransaction);
                $declineTransaction->save();
                $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);

                //Todo send Email
                return ApiUtils::response_fail($responseMessage, 400);

            }
        } else {

            $order->status = self::ORDERSTATUSREJECT;
            $order->save();
            $declineTransaction = new Transaction();
            $declineTransaction->order_id = $order->id;            
            $declineTransaction->amount = 1.00;
            $declineTransaction->action = self::TRANSACTIONACTIONADDANDBUYCREDIT;
            $declineTransaction->credits_old = $user->credits;
            $declineTransaction->result_text = $responseText;
            $declineTransaction->result_code = $code;
            $declineTransaction->result_avs = $avsCode;
            $declineTransaction->result = $result;
            $declineTransaction->result_type = $actionType;
            $declineTransaction->result_cvv = $result_cvv;
            $user->transactions()->save($declineTransaction);
            $declineTransaction->save();
            $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);

            //Todo send Email

            return ApiUtils::response_fail($responseMessage);

        }
    }

    public function save_card_subscribe(Request $request)
    {
        $gw = $this->card_validate($request);
        $user = Auth::user();
        $code = $gw->responses['response_code'];
        $subscription_id = $request->subscription;

        $subscription = Subscription::where('id', '=', $subscription_id)->first();

        if(is_null($subscription)){
            return ApiUtils::response_fail('Invalid subscription id', 400);
        }
        $amount = $subscription->price;
        if($user->credits < $amount){
            return ApiUtils::response_fail('Not enough credits', 400);
        }

        $responseText = $gw->responses['responsetext'];
        $actionType = $gw->responses['type'];
        $avsCode = $gw->responses['avsresponse'];
        $result = $gw->responses['response'];
        $result_cvv = $gw->responses['cvvresponse'];
        $data = $this->card_data_request($request);


        if ($code == "100") {

            $priority = 1;

            $gw->doSaleHybrid($user->id, $data['cc_number'], $data['cc_exp'], $data['cc_cvv'],
                $data['billing_id'], $data['first_name'], $data['last_name'], $data['billing_address'],
                $data['billing_address2'], $data['city'], $data['state'], $data['zip'],
                $data['country'], $data['phone'], $data['transaction_type'], $priority, $data['ip'],
                $amount, null, $subscription->id, $data['status'],
                $data['xid'], $data['eci'], $data['cavv']);


            $code = $gw->responses['response_code'];
            $responseText = $gw->responses['responsetext'];
            $actionType = $gw->responses['type'];
            $avsCode = $gw->responses['avsresponse'];
            $result = $gw->responses['response'];
            $result_cvv = $gw->responses['cvvresponse'];


            $card_type = self::BILLERTYPECREDIT;
            if ($request->card_type == self::BILLERTYPEDEBIT) {
                $card_type = self::BILLERTYPEDEBIT;
            }

            //All process is good
            if ($code == "100") {

                $billing = new UserBillerEdata();
                $billing->billing_id = $data['billing_id'];
                $billing->test_mode = BillingUtils::get_mode();
                $billing->last_four = substr($data['cc_number'], -4);
                $billing->type = $card_type;
                UserBillerEdata::where('user_id', $user->id)->update(['preferred' => 0]);
                $billing->preferred = 1;
                $user->biller_edata()->save($billing);
                $billing->save();

                $transaction = new Transaction();
                $transaction->subscription_id = $subscription->id;
                $transaction->billing_id = $billing->id;                
                $transaction->amount = $amount;
                $transaction->action = self::TRANSACTIONACTIONADDANDSUBSCRIBE;
                $transaction->credits_old = $user->credits;
                $transaction->result_text = $responseText;
                $transaction->result_code = $code;
                $transaction->result_avs = $avsCode;
                $transaction->result = $result;
                $transaction->result_type = $actionType;
                $transaction->result_cvv = $result_cvv;
                $user->transactions()->save($transaction);
                $transaction->save();

                $user_credit_log = new UserCreditLog();
                $user_credit_log->site_id = WhiteLabel::site_id();
                $user_credit_log->credits = $amount;
                $user_credit_log->action = self::SUBSCRIPTION;
                $user_credit_log->credits_old = $user->credits;
                $user->user_credit_logs()->save($user_credit_log);

               
                Log::info('From Accountcontroller save_card_subscribe()  -- User credit old: $'.$user->credits. ' Amount: $'.$amount.' User ID:'.$user->id);
               
               
                $user->credits -= $amount;
                $user->save();

                Log:info('From Accountcontrollersave_card_subscribe() -- User credit new: $'.$user->credits.' User ID:'.$user->id);               


                $userSubscription  = new UserSubscription();
                $userSubscription->user_id = $user->id;
                $userSubscription->subscription_id = $subscription->id;
                $userSubscription->rate  = $amount;
                $userSubscription->user_biller_id = $billing->id; 
                $now = new \DateTime();
                $next_payment = $now->add(new \DateInterval('P1M'));
                $next_payment = $next_payment->format('Y-m-d');
                $userSubscription->next_payment_at = $next_payment;
                $userSubscription->status = "ACTIVE";
                $userSubscription->save();;
    


                //Todo send Email
                $user_subscription_aux = UserSubscription::find($userSubscription->id);
                NotificationsInAppUtils::f_show_new_premium_subscription_in_app($user_subscription_aux);
                EmailUtils::subscribed($user, $user_subscription_aux);           

                return ApiUtils::response_success('You have subscribed successfully. Thank you for using Respectfully™.', Response::HTTP_CREATED);

            } else {

                $declineTransaction = new Transaction();
                $declineTransaction->subscription_id = $subscription->id;                
                $declineTransaction->amount = $amount;
                $declineTransaction->action = self::TRANSACTIONACTIONADDANDSUBSCRIBE;
                $declineTransaction->credits_old = $user->credits;
                $declineTransaction->result_text = $responseText;
                $declineTransaction->result_code = $code;
                $declineTransaction->result_avs = $avsCode;
                $declineTransaction->result = $result;
                $declineTransaction->result_type = $actionType;
                $declineTransaction->result_cvv = $result_cvv;
                $user->transactions()->save($declineTransaction);
                $declineTransaction->save();
                $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);

                //Todo send Email

                return ApiUtils::response_fail($responseMessage, 400);

            }
        } else {

            $declineTransaction = new Transaction();
            $declineTransaction->subscription_id = $subscription->id;           
            $declineTransaction->amount = 1.00;
            $declineTransaction->action = self::TRANSACTIONACTIONADDANDSUBSCRIBE;
            $declineTransaction->credits_old = $user->credits;
            $declineTransaction->result_text = $responseText;
            $declineTransaction->result_code = $code;
            $declineTransaction->result_avs = $avsCode;
            $declineTransaction->result = $result;
            $declineTransaction->result_type = $actionType;
            $declineTransaction->result_cvv = $result_cvv;
            $user->transactions()->save($declineTransaction);
            $declineTransaction->save();
            $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);

            //Todo send Email

            return ApiUtils::response_fail($responseMessage);

        }
    }

    public function get_cards_user(Request $request)
    {
        $user = Auth::user();
        $card = '';
        if (in_array($request->card_type, self::BILLERS)) {
            $card = $request->card_type;
        }
        $cards = BillingUtils::get_user_cards($user->id, $card);

        if($request->checkPromo)
         return response()->json(['cards' => $cards, 'promo' => PromoBuyCredit::where('active', 1)->count()]);

        return $cards;
    }

    public function buy_credits(Request $request)
    {
        
        $user = Auth::user();
        $card = "";

        $promo = $user->promo();
        $promoAmount = 0;

       
        if ($request->card_type == self::BILLERTYPEDEPOSITACCOUNT) {
            $card = self::BILLERTYPEDEPOSITACCOUNT;
        }
        $cards = BillingUtils::get_user_cards($user->id, $card);

        $billers = array_column($cards, 3);

        
        $this->validate($request, [
            'credits' => 'required|integer',
            'biller' => ['required',
                Rule::in($billers)],
            'card_type' => Rule::in(self::BILLERS)

        ]);

        $amount = $request->credits;
        $result_promo = $this->validate_promo_code($request,false);

        if(isset($result_promo->error)){           
            return $result_promo;
        }else{
            if($result_promo != 0){
                $promoAmount = $result_promo['promoAmount'];
                $promoBuyCredit = $result_promo['promoBuyCredit'];
            }
        }
      

        $order = new Order();
        $order->type = self::BUYCREDIT;
        $order->credits = $amount;
        $order->status = self::ORDERSTATUSPENDING;
        $user->orders()->save($order);

        $ip_addr = WhiteLabel::getIpAddress();


        $gw = new gwapi();
        $gw->setLogin(BillingUtils::username(), BillingUtils::password());


        $gw->doSaleAux($amount, $user->id, $request->biller, $order->id, $ip_addr);

        $responseText = $gw->responses['responsetext'];
        $actionType = $gw->responses['type'];
        $avsCode = $gw->responses['avsresponse'];
        $result = $gw->responses['response'];
        $code = $gw->responses['response_code'];
        $result_cvv = $gw->responses['cvvresponse'];

        $user_biller_edata_id = UserBillerEdata::where('billing_id', $request->biller)->first()->id;
        $transaction = new Transaction();
        $transaction->order_id = $order->id;
        $transaction->billing_id = $user_biller_edata_id;
        $transaction->action = self::BUYCREDIT;        
        $transaction->amount = $amount;
        $transaction->credits_old = $user->credits;
        $transaction->result_text = $responseText;
        $transaction->result_code = $code;
        $transaction->result_avs = $avsCode;
        $transaction->result = $result;
        $transaction->result_type = $actionType;
        $transaction->result_cvv = $result_cvv;
        $user->transactions()->save($transaction);
        $transaction->save();


        if ($code == "100") {


            $order->status = self::ORDERSTATUSAPPROVED;
            $order->save();

            $user_credit_log = new UserCreditLog();
            $user_credit_log->site_id = WhiteLabel::site_id();
            $user_credit_log->credits = $amount;
            $user_credit_log->promo = $promo;
            if(isset($promoBuyCredit)){
                $user_credit_log->promo_code = $promoBuyCredit->code;
                $user_credit_log->promo_id = $promoBuyCredit->id;
                $user_credit_log->promo_amount = $promoAmount;
            }
            $user_credit_log->action = self::BUYCREDIT;
            $user_credit_log->credits_old = $user->credits;
            $user->user_credit_logs()->save($user_credit_log);



            Log::info('From Accountcontroller buy_credits()  -- User credit old: $'.$user->credits.  ' Promo: $'.$promo. ' Amount: $'.$amount.' User ID:'.$user->id);
            $user->credits += $amount + $promo + $promoAmount;
            $user->save();
            Log::info('From Accountcontroller buy_credits() -- User credit new: $'.$user->credits.' User ID:'.$user->id);

            //Todo send Email

            return ApiUtils::response_success(['msg'=> 'Purchase Confirmed.', 'purchase'=> $user_credit_log,'credits'=>$user->credits], Response::HTTP_CREATED);
        } else {

            $order->status = self::ORDERSTATUSREJECT;
            $order->save();
            //Todo send Email

            $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode,'BUY_CREDITS');
            return ApiUtils::response_fail($responseMessage, 400);
        }
    }

    public function subscribe(Request $request)
    {

        $user = Auth::user();
        $card = "";
        if ($request->card_type == self::BILLERTYPEDEPOSITACCOUNT) {
            $card = self::BILLERTYPEDEPOSITACCOUNT;
        }
        $cards = BillingUtils::get_user_cards($user->id, $card);

        $billers = array_column($cards, 3);


        $this->validate($request, [
            'subscription' => 'required|integer',
            'biller' => ['required',
                Rule::in($billers)],
            'card_type' => Rule::in(self::BILLERS)

        ]);

        $subscription_id = $request->subscription;
        $subscription = Subscription::where('id', '=', $subscription_id)->first();

        if(is_null($subscription)){
            return ApiUtils::response_fail('Invalid subscription id', 400);
        }
        $amount = $subscription->price;
        $ip_addr = WhiteLabel::getIpAddress();

        $gw = new gwapi();
        $gw->setLogin(BillingUtils::username(), BillingUtils::password());


        $gw->doSaleAux($amount, $user->id, $request->biller, null, $subscription->id, $ip_addr);

        $responseText = $gw->responses['responsetext'];
        $actionType = $gw->responses['type'];
        $avsCode = $gw->responses['avsresponse'];
        $result = $gw->responses['response'];
        $code = $gw->responses['response_code'];
        $result_cvv = $gw->responses['cvvresponse'];

        $user_biller = UserBillerEdata::where('billing_id', $request->biller)->first();
        $transaction = new Transaction();
        $transaction->subscription_id =  $subscription->id;
        $transaction->billing_id = $user_biller->id;
        $transaction->action = self::SUBSCRIPTION;
        $transaction->transaction_type_id = 3;
        $transaction->amount = $amount;
        $transaction->credits_old = $user->credits;
        $transaction->result_text = $responseText;
        $transaction->result_code = $code;
        $transaction->result_avs = $avsCode;
        $transaction->result = $result;
        $transaction->result_type = $actionType;
        $transaction->result_cvv = $result_cvv;
        $user->transactions()->save($transaction);
        $transaction->save();


        if ($code == "100") {

            $user_credit_log = new UserCreditLog();
            $user_credit_log->site_id = WhiteLabel::site_id();
            $user_credit_log->credits = $amount;
            $user_credit_log->action = self::SUBSCRIPTION;
            $user_credit_log->credits_old = $user->credits;
            $user_credit_log->psychic_id = $subscription->user_id;
            $user->user_credit_logs()->save($user_credit_log);
            $user->save();

            $userSubscription  = new UserSubscription();
            $userSubscription->user_id = $user->id;
            $userSubscription->subscription_id = $subscription->id;
            $userSubscription->rate  = $amount;
            $userSubscription->user_biller_id = $user_biller->id;
            $now = new \DateTime();
            $next_payment = $now->add(new \DateInterval('P1M'));
            $next_payment = $next_payment->format('Y-m-d');
            $userSubscription->next_payment_at = $next_payment;
            $userSubscription->status = "ACTIVE";
            $userSubscription->save();;

            $user_subscription_aux = UserSubscription::find($userSubscription->id);
            NotificationsInAppUtils::f_show_new_premium_subscription_in_app($user_subscription_aux);
            EmailUtils::subscribed($user, $user_subscription_aux);           

            //return ApiUtils::response_success('Purchase Confirmed.', Response::HTTP_CREATED);
            return ApiUtils::response_success(['msg'=> 'Purchase Confirmed.', 'purchase'=> new GenericResource($user_credit_log, ['id', 'credits'])], Response::HTTP_CREATED);
        } else {
             //Todo send Email

            $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);
            return ApiUtils::response_fail(['message'=>$responseMessage], 400);
        }
    }

    public function update_card_priority(Request $request)
    {
        
        $user = Auth::user();
        $cards = BillingUtils::get_user_cards($user->id, "");
        $billers = array_column($cards, 3);

        $this->validate($request, [
            'biller' => ['required',
                Rule::in($billers)]

        ]);

        $transactionType = 'update-billing';

        $gwResponse = BillingUtils::manage_card($transactionType, $user->id, $request->biller);

        if ($gwResponse->result == 1) {
            UserBillerEdata::where('user_id', $user->id)->update(['preferred' => 0]);
            UserBillerEdata::where('billing_id', $request->biller)->update(['preferred' => 1]);
            return ApiUtils::response_success('Success', Response::HTTP_CREATED);

        } else {

            return ApiUtils::response_fail('There was an error', Response::HTTP_CONFLICT);
        }
    }

    /*
     * Delete DEBIT card, DEBIT card, DEPOSIT account
     */
    public function delete_card(Request $request)
    {

        $user = Auth::user();
        $card = "";
        if ($request->card_type == self::BILLERTYPEDEPOSITACCOUNT) {
            $card = self::BILLERTYPEDEPOSITACCOUNT;
        }
        $cards = BillingUtils::get_user_cards($user->id, $card);
       
        if ($request->card_type == self::BILLERTYPEDEPOSITACCOUNT) {
            if(count($cards)){
                $billers = [$cards['id']];
            }else{
                $billers = [];
            }
           
        }else{
            $billers = array_column($cards, 3);
        } 

      

        $this->validate($request, [
            'biller' => ['required',
                Rule::in($billers)],
            'card_type' => ['string', Rule::in(self::BILLERS)],

        ]);

        $transactionType = 'delete-customer';
        if (count($cards) > 1 && $card != 'DEPOSIT') {

            $transactionType = 'delete-billing';
        }
        
    
        $gwResponse = BillingUtils::manage_card($transactionType, $user->id, $request->biller);

        if ($gwResponse->result == 1) {
            $biller = UserBillerEdata::where('billing_id', $request->biller)->first();
            UserBillerEdata::where('billing_id', $request->biller)->delete();
            if ($transactionType == 'delete-billing') {

                if ($biller->preferred == 1) {
                    $biller_old = $user->biller_edata()->first();
                    $transactionType = 'update-billing';
                    $gwResponse = BillingUtils::manage_card($transactionType, $user->id, $biller_old->billing_id);
                    $biller_old->preferred = 1;
                    $biller_old->save();

                }
            }else{
                $user->deposit_account = 0;
                $user->save();
            }
            if($card==='DEPOSIT'){
                return ApiUtils::response_success('Your deposit account was removed successfully.'); 
            }else{
                return ApiUtils::response_success('Your card was removed successfully.');
            }

           
        } else {

            return ApiUtils::response_fail('There was an error', Response::HTTP_CONFLICT);
        }
    }


    public function edit_deposit_account(Request $request)
    {

        $user = Auth::user();
        $customer = BillingUtils::checkCustomerVault($user->id);


        $account_types = ['checking', 'savings'];
        $entity_types = ['personal', 'business'];

        $this->validate($request, [
            'checkname' => 'required',
            'account_type' => ['required', Rule::in($account_types)],
            /*'entity_type' => ['required', Rule::in($entity_types)],*/
            'routing_number' => 'required',
            'account_number' => 'required',
            'address_country' => 'required',
        ]);
       
        $biller_old = $user->biller_edata()->first();        
     
        if($biller_old->billing_id != $request->billing_id) {
            return ApiUtils::response_fail('There was an error');
        }       
        $transactionType = 'update-billing-deposit';

        $search = 'XXXXXXXXXX';
        $routing = $request->routing_number;
       if(strpos($routing,$search)!==false){
           $routing = '';
       }
       $account_number = $request->account_number;
      
      
       if(strpos($account_number,$search)!==false){
           $account_number = '';
          
       }

        $deposit_account = [
            'account_name'=>$request->checkname,
            'account_routing' => $routing,
            'account_number' => $account_number,
            'account_type'=> $request->account_type];

           
          
            $gw = new gwapi();
            $gw->setLogin(BillingUtils::username(), BillingUtils::password());

          
         $gwResponse =   $gw->updateDepositAccount($biller_old->billing_id,$deposit_account);       
        $biller_old->save();
        if($gwResponse != 1){
            return ApiUtils::response_fail('Please update your account details and try again');
        }
        else{
            return ApiUtils::response_success("Your deposit account was updated successfully.");
        }
      

       

    }
    public function save_deposit_account(Request $request)
    {

        $user = Auth::user();
        $customer = BillingUtils::checkCustomerVault($user->id);
        $account_types = ['checking', 'savings'];
        $entity_types = ['personal', 'business'];

        $this->validate($request, [
            'checkname' => 'required',
            'account_type' => ['required', Rule::in($account_types)],
            /*'entity_type' => ['required', Rule::in($entity_types)],*/
            'routing_number' => 'required|min:6|max:12',
            'account_number' => 'required|min:7|max:14',
            'address_country' => 'required',
        ]);

        $transactionType = "add_customer";

        // if ($customer > 0) {
        //     $transactionType = 'add_billing';
        // }

        $customerId = $user->id;
        $billing_id = $customerId . '-' . rand(1, 999999999999);


        $ip_addr = WhiteLabel::getIpAddress();


        $name = htmlspecialchars(stripslashes(trim($request->checkname)));
        $accountType = htmlspecialchars(stripslashes(trim($request->account_type)));
        $entityType = htmlspecialchars(stripslashes(trim($request->entity_type)));
        $routing = htmlspecialchars(stripslashes(trim($request->routing_number)));
        $account = htmlspecialchars(stripslashes(trim($request->account_number)));
        $country = htmlspecialchars(stripslashes(trim($request->address_country)));
        $bankName = htmlspecialchars(stripslashes(trim($request->bank_name)));
        


        $gw = new gwapi();
        $gw->setLogin(BillingUtils::username(), BillingUtils::password());
        $gw->addDepositAccount($customerId, $name, $accountType, $entityType, $routing, $account, $country, $billing_id, $transactionType, $ip_addr,$bankName);
        $responseText = $gw->responses['responsetext'];
        $actionType = $gw->responses['type'];
        $avsCode = $gw->responses['avsresponse'];
        $result = $gw->responses['response'];
        $code = $gw->responses['response_code'];
        $result_cvv = $gw->responses['cvvresponse'];


        if ($code == "100") {

            $billing = new UserBillerEdata();
            $billing->billing_id = $billing_id;
            $billing->test_mode = BillingUtils::get_mode();
            $billing->last_four = substr($account, -4);
            $billing->type = self::BILLERTYPEDEPOSITACCOUNT;
            $user->biller_edata()->save($billing);
            $billing->save();

            $user->deposit_account = 1;
            $user->save();
            return ApiUtils::response_success("Your deposit account was added successfully.");


        } else {

            $declineTransaction = new Transaction();
            
            $declineTransaction->action = self::TRANSACTIONACTIONADD_DEPOSIT_ACCOUNT;
            $declineTransaction->result_text = $responseText;
            $declineTransaction->result_code = $code;
            $declineTransaction->result_avs = $avsCode;
            
            $declineTransaction->result = $result;
            $declineTransaction->result_type = $actionType;
            $declineTransaction->result_cvv = $result_cvv;
            $user->transactions()->save($declineTransaction);
            $declineTransaction->save();
            //$responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode);

            return ApiUtils::response_fail('Please update your account details and try again.');
        }

    }
    public function save_paypal_account(Request $request){


        $request->validate([
            'email' => 'required|email',          
        ]);
        $user = Auth::user();
        if($user->isPsychic()){
           $user->paypal_account = $request->email;
           $user->deposit_account = 1;          
           $user->save();
           return ApiUtils::response_success("Your paypal account was added successfully.");  
        }
       
    }

    public function delete_paypal_account(Request $request){


        $user = Auth::user();
        if($user->isPsychic()){
           $user->paypal_account = '';
           $user->deposit_account = 0;          
           $user->save();
           return ApiUtils::response_success("Your paypal account was removed successfully.");  
        }
       
    }


    private function card_validate(Request $request)
    {

        $data = $this->card_data_request($request);
        $amount = 1.00;
        $user = Auth::user();

        $gw = new gwapi();
        $gw->setLogin(BillingUtils::username(), BillingUtils::password());
        $gw->validateCard($amount, $data['cc_number'], $data['cc_exp'], $data['cc_cvv'],
            $data['first_name'], $data['last_name'], $data['billing_address'],
            $data['billing_address2'], $data['city'], $data['state'], $data['zip'], $data['country'], $data['phone'],
            $data['ip'], $user->id);

        return $gw;
    }

    public function set_contact_status(Request $request) {

        $user = Auth::user();
        $services = $user->userservice()->where('active',1)->first();
        if($services || !$request->get('online')){
            $user->online = $request->get('online');
            $user->save();
        }      
       
        return ApiUtils::response_success(['data' => ['online' => $user->online]]);

    }
    public function validate_promo_code(Request $request,$just_validate = true){

        $amount = $request->credits;
        $promoAmount = 0;
        $user = Auth::user();
     
        if($request->promoCode){
            
            if($promoBuyCredit = PromoBuyCredit::where('code', $request->promoCode)->first()){

              if(!$promoBuyCredit->active)
               return ApiUtils::response_fail(['promo' => true,'message'=> 'This promo is inactive'], 400);
              if(UserCreditLog::where('promo_code', $request->promoCode)->where('user_id', $user->id)->where('action', self::BUYCREDIT)->count())
               return ApiUtils::response_fail(['promo' => true,'message'=> 'Promo code already redeemed'], 400);
        
              for($i = 0, $j = 1; $i < count($promoBuyCredit->credits); $i++, $j++){

                if($amount >= $promoBuyCredit->credits[$i]['purchase'] && (!isset($promoBuyCredit->credits[$j]) || $amount < $promoBuyCredit->credits[$j]['purchase'])){
                     $promo_amount =$promoBuyCredit->credits[$i]['extra'];
                    if($just_validate){
                         return $promo_amount;
                     }                   
                     $promoAmount = ['promoAmount'=>$promo_amount,'promoBuyCredit'=>$promoBuyCredit];
                   break;
                 
                }
              }               

            }
            else {
                return ApiUtils::response_fail(['promo' => true,'message'=> 'Invalid promo code'], 400);
            }
        }
        return $promoAmount;
    }
    public function validate_apple_session(Request $request){

         
        $validation_url = $request->appleUrl;
        $result_promo = $this->validate_promo_code($request,false);

        if(isset($result_promo->error)){           
            return $result_promo;
        }

           if( "https" == parse_url($validation_url, PHP_URL_SCHEME) && substr( parse_url($validation_url, PHP_URL_HOST), -10 )  == ".apple.com" ){

            // create a new cURL resource
            $ch = curl_init();        
            $data = '{"merchantIdentifier":"merchant.com.respectfully", "domainName":"'.$_SERVER["HTTP_HOST"].'", "displayName":"Respectfully"}';
             
            $key =WhiteLabel::file_path(WhiteLabel::config('apple')->apple_pay['client_key']);
            if(!$key){
                $key =WhiteLabel::file_path(WhiteLabel::config('apple')->apple_pay['client_key']);
                if(!$key){
                    $key =WhiteLabel::file_path(WhiteLabel::config('apple')->apple_pay['client_key']);
                }
            }

            curl_setopt($ch, CURLOPT_URL, $validation_url); 
            curl_setopt($ch, CURLOPT_POST, 1);           
            curl_setopt($ch, CURLOPT_SSLCERT, WhiteLabel::file_path(WhiteLabel::config('apple')->apple_pay['client_certificate']));            
            curl_setopt($ch, CURLOPT_SSLKEY,$key);
            curl_setopt($ch, CURLOPT_SSLKEYPASSWD,WhiteLabel::config('apple')->apple_pay['password']);            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Length: ".strlen($data))); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);          
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 


            if(!curl_exec($ch))
            {
                print_r($ch);
                echo '{"curlError":"' . curl_error($ch) . '"}';
            }        
            // close cURL resource, and free up system resources
            curl_close($ch);
            //unset($ch);            
        }
    }
    public function pay_with_apple(Request $request){

        $gw = new gwapi();
        //$gw->setLogin(BillingUtils::username(), BillingUtils::password());
        $user = Auth::user();
        $amount = $request->credits;
        $apple_identifier = $request->transactionId;
        $promo = $user->promo();
        $promoAmount = 0;

        $result_promo = $this->validate_promo_code($request,false);
        if(isset($result_promo->error)){           
            return $result_promo;
        }else{
            if($result_promo != 0){
                $promoAmount = $result_promo['promoAmount'];
                $promoBuyCredit = $result_promo['promoBuyCredit'];
            }
        }
       
        $order = new Order();
        $order->type = self::BUYCREDIT;
        $order->credits = $amount;
        $order->status = self::ORDERSTATUSPENDING;
        $user->orders()->save($order);

        $transactionType = "add_customer";
        $user = Auth::user();
        $customer = BillingUtils::checkCustomerVault($user->id);
        if ($customer > 0) {
            $transactionType = 'add_billing';
        }
        $ip_addr = WhiteLabel::getIpAddress();
        $billing_id = $user->id . '-' . rand(1, 999999999999);


        $data['vault_id']=$user->id;
        $data['transaction_type']=$transactionType;
        $data['billing_id']=$billing_id;
        $data['ip']=$ip_addr;
        $data['order_id']=$order->id;

       $gw->buy_credits_apple_pay($request->paymentData,$amount,$request->billingDetails,$data);
       $code = $gw->responses['response_code']; 
       $responseText = $gw->responses['responsetext'];
       $actionType = $gw->responses['type'];
       $avsCode = $gw->responses['avsresponse'];
       $result = $gw->responses['response'];
       $result_cvv = $gw->responses['cvvresponse'];


        if ($code == "100") {

            $order->status = self::ORDERSTATUSAPPROVED;
            $order->save();


            $billing = new UserBillerEdata();
            $billing->billing_id = $data['billing_id'];
            $billing->test_mode = BillingUtils::get_mode();
            $billing->last_four = substr($request->paymentMethod['displayName'], -4);
            $billing->type = $request->paymentMethod['type'];
            $user->biller_edata()->save($billing);
            $billing->save();

            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->billing_id = $billing->id;                
            $transaction->amount = $amount;
            $transaction->action = self::BUYCREDIT;
            $transaction->credits_old = $user->credits;
            $transaction->result_text = $responseText;
            $transaction->result_code = $code;
            $transaction->result_avs = $avsCode;
            $transaction->result = $result;
            $transaction->result_type = $actionType;
            $transaction->result_cvv = $result_cvv;
            $transaction->apple_identifier = $apple_identifier;
            $transaction->edata_transaction_id = $gw->responses['transactionid'];
            $user->transactions()->save($transaction);
            $transaction->save();

            $user_credit_log = new UserCreditLog();
            $user_credit_log->site_id = WhiteLabel::site_id();
            $user_credit_log->credits = $amount;
            $user_credit_log->promo = $promo;
            if(isset($promoBuyCredit)){
                $user_credit_log->promo_code = $promoBuyCredit->code;
                $user_credit_log->promo_id = $promoBuyCredit->id;
                $user_credit_log->promo_amount = $promoAmount;
            }
            $user_credit_log->action = self::BUYCREDIT;
            $user_credit_log->credits_old = $user->credits;
            $user_credit_log->transaction_id = $transaction->id;
            $user->user_credit_logs()->save($user_credit_log);

            Log::info('From Accountcontroller pay_with_apple() -- User credit old: $'.$user->credits. ' Amount: $'.$amount.' User ID:'.$user->id);
            $user->credits += $amount + $promo + $promoAmount;
            $user->save();
            Log::info('From Accountcontroller pay_with_apple() -- User credit new: $'.$user->credits.' User ID:'.$user->id);


            //Todo send Email
            return ApiUtils::response_success(['msg'=> 'Purchase Confirmed.', 'purchase'=> $user_credit_log,'credits'=>$user->credits], Response::HTTP_CREATED);
            //return ApiUtils::response_success('Purchase Confirmed.', Response::HTTP_CREATED);

        } else {


            $order->status = self::ORDERSTATUSREJECT;
            $order->save();
            $declineTransaction = new Transaction();
            $declineTransaction->order_id = $order->id;                
            $declineTransaction->amount = $amount;
            $declineTransaction->action = self::BUYCREDIT;
            $declineTransaction->credits_old = $user->credits;
            $declineTransaction->result_text = $responseText;
            $declineTransaction->result_code = $code;
            $declineTransaction->result_avs = $avsCode;
            $declineTransaction->result = $result;
            $declineTransaction->result_type = $actionType;
            $declineTransaction->result_cvv = $result_cvv;
            $user->transactions()->save($declineTransaction);
            $declineTransaction->save();
            $responseMessage = BillingUtils::getErrorMessageByCode($code, $avsCode,'BUY_CREDITS');

            //Todo send Email

            return ApiUtils::response_fail($responseMessage, 400);

        }

    }
    public function set_login_counter(){
        $user = Auth::user();
        if($user){
            $user->login_counter = 3;
            $user->save();
            return 'true';
        }
        return 'false';        
    }
    function pusher_authorizer(Request $request){

        $pusher = new Pusher\Pusher(env('PUSHER_APP_KEY'),env('PUSHER_APP_SECRET'),env('PUSHER_APP_ID'),array('cluster' => env('PUSHER_APP_CLUSTER'),));
    
        if(strpos($request->input('channel_name'),'presence') !== false){    
            $user = Auth::user();
            return  $pusher->presence_auth($request->input('channel_name'),$request->input('socket_id'),$user->id,$user);
        }else{
              return  $pusher->socket_auth($request->input('channel_name'),$request->input('socket_id'));
        }       
      
    }




}
