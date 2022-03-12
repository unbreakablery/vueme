<?php namespace App\Http\Controllers\Api;




use App\Models\User;
use App\Models\UserReferral;
use App\Services\NotificationUtils;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ApiUtils;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\GenericResource;
use App\Http\Resources\v1\GenericResourceCollection;
use App\Http\Resources\v1\SubscriptionResource;
use App\Http\Resources\v1\SubscriptionResourceCollection;
use App\Models\BlockedUser;
use App\Models\Subscription;
use App\Models\UserProfile;
use App\Models\UserSubscription;
use Illuminate\Validation\Rule;

use App\Services\EmailUtils;
use Carbon\Carbon;
use CreateUserReferral;

class PsychicController extends Controller {

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->middleware('role:1');
        $this->middleware('verifield');
        $this->auth = $auth;
    }
    public function UpdatePsychic(Request $request)
    {

       
        $this->validate($request, [
            'period' => ['string', Rule::in(['Monthly','Daily'])],
            'goal'=> 'integer|min:1'
        ]);

         
        $user = Auth::user();
        $period =  $request->input('period');
        $goal =  $request->input('goal');
        
        if($period && $goal){
            if($period == 'Monthly'){
              
                $user->earnings_goal_month = $goal;
            }else{
               
                $user->earnings_goal_daily = $goal;
            }

            $user->save();

            return ApiUtils::response_success('OK',Response::HTTP_OK);

        }

       
    }

    public function referralEmail(Request $request)
    {

        $request->validate([
            'referral_email' => ['required', 'email', 'unique:user_referral',  'bail'],
        ]);
        
        if (!empty($request['referral_email'])) {
            $request['referral_email'] = trim($request['referral_email']);
        }
        

        $user = Auth::user();
        $user_referral = new UserReferral();
        $user_referral->referral_email = $request['referral_email'];
        $user_referral->user_id = $user->id;
        $user_referral->action = 'Invite Sent';

        if ($user_referral->save()){
                EmailUtils::send_referral_email($user,$request['referral_email']);
                return response()->json(['message'=> 'Sent Email'], 200);
            }
        return ApiUtils::response_fail(['message'=> 'An invitation has been sent to this email'], 400);
        
    }


    public function referralEmailResend(Request $request)
    {
        
        $user = Auth::user();
        

        $user_referral = UserReferral::where(array('id' => $request['line']))->first();
        $user_referral->action = 'Invite Resend';
        $user_referral->save();

        EmailUtils::send_referral_email($user,$request['referral_email']);
        return response()->json(['message'=> 'Sent Email'], 200);


    }
    public function getSubscription()
    {
        $user = Auth::user();
        $subs = Subscription::where('user_id', '=', $user->id)->where('name', '=', "Subscription")->first();
        return ApiUtils::response_success(['data' => $subs && $subs->price ? $subs->price : 0], 200);
    }

    public function saveSubscription(Request $request)
    {

        $request->validate([
            'price' => 'required|numeric|min:2',
        ]);

        $user = Auth::user();
        $subs = Subscription::where('user_id', '=', $user->id)->where('name', '=', "Subscription")->first();
        if(!$subs) {
        $subs = new Subscription();
        $subs->user_id = $user->id;
        $subs->name = "Subscription";
        $subs->type = "MEDIA";
        $subs->duration_period = "MONTH";
        $subs->status = 1;
        }
        $subs->price = $request->price;        
        $subs->save();
        return ApiUtils::response_success(['status' => "success"], 200);
    }

    public function modelSubscriptions(Request $request)
    {

        $user = Auth::user();

        $subscriptions = $user->user_fan_subscribed()->orderBy('created_at', 'DESC')->get();

        $items = $subscriptions->filter(function ($value, $key) {
            return $value->status == 'ACTIVE' && !$value->snapchat_status;
        })->merge(
            $subscriptions->filter(function ($value, $key) {
                return $value->status == 'EXPIRED' && $value->snapchat_status != 'DELETED';
            })
        )->merge(
            $subscriptions->filter(function ($value, $key) {
                return $value->snapchat_status == 'ADDED' && $value->status != 'EXPIRED';
            })
        )->merge(
            $subscriptions->filter(function ($value, $key) {
                return $value->snapchat_status == 'DELETED';
            })
        )->merge(
            $subscriptions->filter(function ($value, $key) {
                return $value->status == 'INACTIVE';
            })
        )->merge(
            $subscriptions->filter(function ($value, $key) {
                return $value->status == 'BLOCKED';
            })
        );
        for($i=0;$i<count($items);$i++)
            {
                //$sub=Subscription::where('role_id', '=',)
                $user_p=UserProfile::where('user_id' , '=', $items[$i]->user_id)->first();
                $items[$i]->name=$user_p ? $user_p->name . ' ' . $user_p->last_name : '';
            }

        return new SubscriptionResourceCollection($items->unique());

    }

    public function blockUser(Request $request) {
        $user = Auth::user();
        $is_blocked = BlockedUser::where('model_id','=',$user->id)->where('user_id','=',$request->user_id)->first();
        if($is_blocked)
            return ApiUtils::response_fail(['message'=> 'User has already been blocked'], 400);
        else{
            $blocked = new BlockedUser();
            $blocked->user_id=$request->user_id;
            $blocked->model_id=$user->id;
            $now= Carbon::now();
            $blocked->created_at = $now;
            $blocked->updated_at = $now;
            $blocked->save(['timestamps' => false]);
            $model_sub = $user->subscriptions()->where("name","=","Subscription")->first();
            if($model_sub){ 
                $sub = UserSubscription::where('subscription_id','=',$model_sub->id)->where('user_id','=',$request->user_id)->first();
                if($sub)
                  {
                    $sub->status = "BLOCKED";
                    $sub->save();
                    return new SubscriptionResource($sub);
                  }   
                  else
                  return ApiUtils::response_fail(['message'=> 'User subscription not found'], 400);
            }
            else
            return ApiUtils::response_fail(['message'=> 'Your subscription was not found'], 400);
        }
    }
}
