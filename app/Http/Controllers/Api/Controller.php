<?php namespace App\Http\Controllers\Api;


use App\Models\model_chat_room;
use App\Models\user_1_1_chat_request;
use App\Models\fan_chat_room;
use App\Services\ApiUtils;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redis;

use App\Models\User;


use Accounting;
use Auth;
use Exception;
use DB;
use Log;
use Hash;
use Request;
use Response;
use Validator;

class Controller extends \App\Http\Controllers\Controller
{

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    protected function _star_json(star $star, $input = [])
    {

//		Log::debug("In Controller::_star_json with "
//			. "\n\n************** \$star = " . print_r($star->profile_name, true)
//			. "\n\n************** \$in = " . print_r($input, true)
//		);
//
        if (!$star) {
            return [];
        }

        if (empty($input)) {
            $input = ['profile' => true];
        }

        // Send short star JSON for supporter transaction calls
        if (isset($input['short_star']) && $input['short_star'] == true) {
            return [
                'profile_name' => $star->profile_name,
                'is_501c3' => false
            ];
        }

        $out = [];

        if (!empty($input['refer_stats'])){
            //Log::debug("In Controller::_star_json with proessing refer_stats");
            $out += [
                'profile_image'=>$this->_star_profile_image($star),
                'profile_name' => $star->profile_name,
                'profile_name_url' => $star->profile_url($star->profile_name,$star->id),
                'created_at'=>$star->created_at->toDateString()
            ];

            // Log::debug("In Controller::_star_json with proessing refer_stats ".print_r($out,true));

        }

        if (!empty($input['profile'])) {

            $out += [
                'id' => $star->id,
                'profile_name' => $star->profile_name,
                'profile_name_url' => $star->profile_url($star->profile_name,$star->id),
                'referral_url'=> $star->full_referral_url,
                'gender' => $star->gender,
                'last_on' => ApiUtils::time($star->last_on),
                'profile_image' => $this->_star_profile_image($star),
                'about' => $star->about,
                'profile_bg_image' => $star->full_profile_bg_image,
                'available' => explode(',', $star->available),
                'services' => explode(',', $star->services),
                'video_chat_flags' => $this->_star_stream_types_json($star),
                'is_online' => $star->status != 'OFFLINE',
                'featured_vod' => $star->featured_media_purchase_id,
                'followers' => user_notify_online::followers_count($star->id),
            ];

            if(\WhiteLabel::config('star')->search_returns_videos){
                $out['broadcast_cnt'] = $star->vod_count();
            } else {
                $out['broadcast_cnt'] = $star->broadcast_cnt;
            }

            if($out['profile_image']){
                $out += ['profile_images' => $this->_star_profile_images($star)];
            }

            if (!empty($input['social_link'])){
                $email = isset($star->user->email) ? $star->user->email : '';
                $lead = lead::where('email',$email)->orderBy('id','DESC')->first();
                if($lead){
                    $out +=['social_link'=>$lead->social_media_link];
                }
            }

            if (empty($input['no_video_details'])){
                $out += ['featured_vod_data' => $this->_star_featured_media_purchase_json($star,true)];
            }

            if (!empty($star->star_accounting->charity)) {
                $out['charity'] = [
                    'name' => $star->star_accounting->charity->name,
                ];
            } else {
                $out['charity'] = null;
            }
            if (!empty($input['501c3'])) {
                $out['is_501c3'] = (($star->tax_type) === "501C3");
            } else {
                $out['is_501c3'] = false;
            }
        }


        if (!empty($input['category'])) {
            if ($star->star_category && $star->star_category->count()) {
                $category = [];
                foreach ($star->star_category as $cat) {
                    $category[] = [
                        'id' => $cat->category->id,
                        'name' => $cat->category->name,
                    ];
                }
                $out['category'] = $category;
            } else {
                $out['category'] = null;
            }
        }

        if (!empty($input['thumb'])){
            $out += [
                'thumb'=> $this->_star_thumb_images($star)
            ];

        }

        if (!empty($input['is_contact'])) {
            $out += [
                'contact' => $this->_star_is_contact_json($star),
            ];
        }

        if (!empty($input['is_in_1_1_queue'])) {
            $out += [
                'is_in_1_1_queue' => $this->_star_is_in_1_1_queue_json($star),
            ];
        }

        if (!empty($input['is_favorite'])) {
            $out += [
                'is_favorite' => $this->_star_is_favorite_json($star),
            ];
        }

        if (!empty($input['rates'])) {
            $out += [
                'rates' => $this->_star_rates_json($star->id),
            ];
        }

        if (!empty($input['is_subscription'])) {
            $out += [
                'subscription' => $this->_star_is_subscription_json($star),
            ];
        }

        if (!empty($input['subscriptions'])) {
            $out += [
                'subscriptions' => $this->_star_subscriptions_json($star->id,$input),
            ];
        }

        if (!empty($input['live_stream'])) {
            $out += [
                'live_stream' => $this->_star_live_stream_json($star),
            ];
        }

        if (!empty($input['playlists'])){
            $out += ['playlists' => $this->_star_playlists_short_json($star)];
        }

        if (!empty($input['user_media_subscribe'])) {
            $params = [];
            if ( !empty($input['department']))
            {
                if ($input['department'] == "ALL")
                {
                    $departments = [];
                    foreach (\WhiteLabel::config('media')->media_departments as $department)
                    {
                        $params['department']     = $department;
                        $departments[$department] = $this->_star_user_media_subscribe_json($star ,$params);
                    }
                } else {
                    $params['department'] = $input['department'];
                    $departments = $this->_star_user_media_subscribe_json($star, $params);
                }
            } else {
                $departments = $this->_star_user_media_subscribe_json($star, $params);
            }
            $out += [
                'library_subscribed' => $departments ,
            ];
            $out += [
                'library_subscribed' => $this->_star_user_media_subscribe_json($star,$params),
            ];
        }

        if (!empty($input['user_media_purchase'])) {
            $params = $input;
            if ( !empty($input['department']))
            {
                if ($input['department'] == "ALL")
                {
                    if (!empty($input['sort_pinned'])) {
                        $params['sort_pinned'] = true;
                    }
                    $departments = [];
                    foreach (\WhiteLabel::config('media')->media_departments as $department)
                    {
                        $params['department']     = $department;
                        $departments[$department] = $this->_star_user_media_purchase_json($star ,$params);
                    }
                } else {
                    $params['department'] = $input['department'];
                    $departments = $this->_star_user_media_purchase_json($star, $params);
                }
            } else {
                $departments = $this->_star_user_media_purchase_json($star, $params);
            }
            $out += [
                'library_purchased' => $departments ,
            ];
        }

        if (!empty($input['media_purchase']))
        {
            $params = $input;
            if ( !empty($input['department']))
            {
                if ($input['department'] == "ALL")
                {
                    $departments = [];
                    foreach (\WhiteLabel::config('media')->media_departments as $department)
                    {
                        $params['department']     = $department;
                        $departments[$department] = $this->_star_media_purchase_json($star ,$params);
                    }
                } else {
                    $params['department'] = $input['department'];
                    $departments = $this->_star_media_purchase_json($star, $params);
                }
            } else {
                $departments = $this->_star_media_purchase_json($star, $params);
            }
            $out += [
                'library' => $departments ,
            ];
        }

        if (!empty($input['media_purchase_count']))
        {
            $params = $input;
            if ( !empty($input['count_department']))
            {
                if ($input['count_department'] == "ALL")
                {
                    $count_departments = [];
                    foreach (\WhiteLabel::config('media')->media_departments as $count_department)
                    {
                        $params['department']     = $count_department;
                        $count_departments[$count_department] = $this->_star_media_purchase_count($star ,$params);
                    }
                } else {
                    $params['department'] = $input['count_department'];

                    if (!empty($input['sort'])) {
                        $params['sort'] = $input['sort'];
                    }
                    if (!empty($input['purchase_count'])) {
                        $params['purchase_count'] = $input['purchase_count'];
                    }

                    $count_departments = $this->_star_media_purchase_count($star, $params);
                }
            } else {
                $count_departments = $this->_star_media_purchase_count($star, $params);
            }
            $out += [
                'media_count' => $count_departments ,
            ];
        }

        if (!empty($input['stream_types'])) {
            $out += [
                'video_chat_flags' => $this->_star_stream_types_json($star),
            ];
        }

        if (!empty($input['services'])) {
            $out += [
                'services' => $this->_star_services_json($star),
            ];
        }


        return $out;
    }

    protected function _star_payout_info_json(star $star, $input = [])
    {
        $spi = star_pay_info::where('star_id', $star->id)->first();
        $out = [];

        if (empty($spi)) {
            return $out;
        }

        $out += [
            'star_id' => $spi->star_id,
            'city' => $spi->city,
            'subdivision' => $spi->subdivision,
            'country' => $spi->country,
            'postal_code' => $spi->postal_code,
            'tax_type' => $spi->tax_type
        ];

        if ($spi->address_line_1) {
            $out += [
                'address_line_1' => $spi->address_line_1
            ];
        }

        if ($spi->address_line_2) {
            $out += [
                'address_line_2' => $spi->address_line_2
            ];
        }

        if ($spi->bank_name) {
            $out += [
                'bank_name' => $spi->bank_name
            ];
        }

        if ($spi->bank_account_type) {
            $out += [
                'bank_account_type' => $spi->bank_account_type
            ];
        }

        if ($spi->bank_routing_number) {
            $out += [
                'bank_routing_number' => $spi->bank_routing_number
            ];
        }

        if ($spi->bank_account_number) {
            $out += [
                'bank_account_number' => $spi->bank_account_number
            ];
        }

        if ($spi->bank_verified) {
            $out += [
                'bank_verified' => $spi->bank_verified
            ];
        }

        if ($spi->bank_address) {
            $out += [
                'bank_address' => $spi->bank_address
            ];
        }

        if ($spi->iban) {
            $out += [
                'iban' => $spi->iban
            ];
        }

        if ($spi->sort_code) {
            $out += [
                'sort_code' => $spi->sort_code
            ];
        }

        if ($spi->swift_bac_code) {
            $out += [
                'swift_bac_code' => $spi->swift_bac_code
            ];
        }

        if ($spi->ifsc_code) {
            $out += [
                'ifsc_code' => $spi->ifsc_code
            ];
        }

        if ($spi->routing_code) {
            $out += [
                'routing_code' => $spi->routing_code
            ];
        }

        if ($spi->tax_tin) {
            $out += [
                'tax_tin' => $spi->tax_tin
            ];
        }

        if ($spi->tax_tin_type) {
            $out += [
                'tax_tin_type' => $spi->tax_tin_type
            ];
        }

        if ($spi->bank_address_line_1) {
            $out += [
                'bank_address_line_1' => $spi->bank_address_line_1
            ];
        }


        if ($spi->bank_address_line_2) {
            $out += [
                'bank_address_line_2' => $spi->bank_address_line_2
            ];
        }


        if ($spi->bank_city) {
            $out += [
                'bank_city' => $spi->bank_city
            ];
        }


        if ($spi->bank_subdivision) {
            $out += [
                'bank_subdivision' => $spi->bank_subdivision
            ];
        }


        if ($spi->bank_country) {
            $out += [
                'bank_country' => $spi->bank_country
            ];
        }


        if ($spi->bank_postal_code) {
            $out += [
                'bank_postal_code' => $spi->bank_postal_code
            ];
        }


        return $out;
    }


    protected function _star_settings_analytics_json(star $star,$input = []){
        $out = ['star_id'=>$star->id
        ];
        $star_id = $star->id;
        $args = [];


        $star_surcharge_percent = $star->surcharge_percent;

        // Generate periods
        $periods = [
            'This Week' => [
                date('Y-m-d H:m:s' , strtotime('-7 day '))
                ,date('Y-m-d H:m:s')]

            ,'Last Week' => [
                date('Y-m-d H:m:s' , strtotime('-14 day'))
                ,date('Y-m-d H:m:s' , strtotime('-7 day '))
            ]



//          For current design we just need this week and last week.  Previous design needed more!
//			,'This Month' => [
//				date('Y-m-d' , strtotime('-30 day'))
//				,date('Y-m-d',strtotime('-1 day') )
//			]
//			,'Last Month' => [
//				date('Y-m-d' , strtotime('-60 day'))
//				,date('Y-m-d' , strtotime('-31 day'))
//
//			]
//			,'This Year' => [
//				date('Y-m-d' , strtotime('-360 day'))
//				,date('Y-m-d',strtotime('-1 day') )
//			]
//			,'Last Year' => [
//				date('Y-m-d' , strtotime('-720 day'))
//				,date('Y-m-d' , strtotime('-361 day'))
//
//			]
        ]
        ;
        //$args['periods']=$periods ;

        // Categories
        $categories = [];
        $rates = [];
        $stats = [];

        $financial_categories = [
            'Subscriptions'
            ,'Connect'
            ,'Connect refund'
            ,'Purchases'
            ,'SMS'
            ,'MMS'
            ,'Voice'
            ,'1-1 Video Chat'
        ];


        $categories['Subscriptions'] = \WhiteLabel::config('accounting')->action_payout_subscription;
        $rates['Subscriptions'] = \WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Subscriptions'][0]];
        $stats['Subscriptions'] = ['subscriptions_new_or_renew'];

        $categories['Connect'] = \WhiteLabel::config('accounting')->action_payout_connect;
        $rates['Connect'] = \WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Connect'][0]];
        $stats['Connect'] = ['connect_count'];

        $categories['SMS'] = \WhiteLabel::config('accounting')->action_payout_sms;
        $rates['SMS'] = \WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Connect'][0]];
        $stats['SMS'] = ['sms_count'];

        $categories['MMS'] = \WhiteLabel::config('accounting')->action_payout_mms;
        $rates['MMS'] = \WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Connect'][0]];
        $stats['MMS'] = ['mms_count'];

        $categories['Voice'] = \WhiteLabel::config('accounting')->action_payout_voice;
        $rates['Voice'] = \WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Connect'][0]];
        $stats['Voice'] = ['voice_calls'];

        $categories['1-1 Video Chat'] = \WhiteLabel::config('accounting')->action_payout_vchat;
        $rates['1-1 Video Chat'] = \WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Connect'][0]];
        $stats['1-1 Video Chat'] = ['1_1_video_chat_minutes','1_1_video_chat_calls'];


        $categories['Connect refund'] = \WhiteLabel::config('accounting')->twilio_refund_actions;
        $rates['Connect refund'] = -(\WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Connect'][0]]);
        $stats['Connect refund']=[];

        $categories['Purchases'] = \WhiteLabel::config('accounting')->action_payout_purchase;
        $rates['Purchases'] = (\WhiteLabel::config('accounting')->action_payout[$star->star_accounting
            ->pay_scale][$categories['Purchases'][0]]);
        $stats['Purchases']=[];

        $categories['Subscribers']=[];
        $stats['Subscribers'] = ['subscribers'];

        $categories['Followers']=[];
        $stats['Followers'] = ['followers'];
        $net = 'gross';



        foreach ( $periods as $period=>$interval )
        {
            //Log::debug("Calculating data for $period");
            $args['settings_analytics'][$period]['title']=$period;
            $total = 0;
            foreach ($categories as $category=>$actions){
                //Log::debug(">>>>>>>> Calculating data for $category");

                if (in_array($category,$financial_categories))
                {
                    $args['settings_analytics'][$period][$category]             =
                        user_credit_log::get_star_earning_by_action_and_interval($star_id ,$actions ,$interval ,
                            $rates[$category]+$star_surcharge_percent);
                    $args['settings_analytics'][$period][$category]['category'] = $category;
                    $args['settings_analytics'][$period][$category]['earned']   =
                        round($args['settings_analytics'][$period][$category]['earned']
                            ,2);
                    $total                                           += $args['settings_analytics'][$period][$category]['earned'];
                }
                // Null out the stats until we are recording them.
                foreach ($stats[$category] as $name){
                    // switch statement to fill in stats as we have them.
                    switch ($name){
                        case 'connect_count':
                        case 'sms_count':
                        case 'mms_count':
                        case '1_1_video_chat_minutes':
                        case 'voice_calls':
                        case 'subscriptions_new_or_renew':
                            // Connect count is number of transactions
                            $value = $args['settings_analytics'][$period][$category]['count'];
                            break;
                        case '1_1_video_chat_calls':
                            // Connect count is number of transactions
                            $value = star_chat_room::calls_star_interval($star,$interval);
                            break;
                        case 'subscribers':
                            $value = user_subscribe::star_subscriber_count($star_id,$interval[1]." 00:00:00");
                            break;
                        case 'followers':
                            $value = user_notify_online::followers_count($star_id,$interval[1]." 00:00:00");
                            break;
                        default:
                            $value = null;
                    }
                    $args['settings_analytics'][$period][$category][$name] = $value;
                }

            }
            $args['settings_analytics'][$period]['total_earnings']=round($total,2);

        }

        return $args;
    }

    protected function _star_thumb_images($star)
    {

        $images = $this->_star_profile_images($star);
        array_shift($images);
        return $images ;

    }
    protected function _star_profile_image($star)
    {
        return $star->profile_v1_image([500, 500]);
    }

    protected function _star_profile_images($star)
    {
        return [
            [
                'width' => 250,
                'height' => 250,
                'url' => $star->profile_v1_image([250, 250]),
            ],
            [
                'width' => 500,
                'height' => 500,
                'url' => $star->profile_v1_image([500, 500]),
            ],
            [
                'width' => 1000,
                'height' => 1000,
                'url' => $star->profile_v1_image([1000, 1000]),
            ],
        ];
    }

    protected function _star_is_contact_json($star)
    {
        $is_contact = $contact_number = null;
        if (Auth::check()) {
            $is_contact = user_network::is_user_network($star->id, Auth::user()->id);
            if ($is_contact) {
                $contact_number = $this->_twilio()->get_number_intl($star->user->id, $star->id, Auth::user()->country_code);
            }
        }
        $active_until = strtotime('+30 days');
        if ($is_contact) {
            $active_until = $is_contact->active_until_timestamp;
        }
        return [
            'contact_number' => $contact_number,
            'is_contact' => !empty($is_contact),
            'contact_active_until' => ApiUtils::time($active_until),
        ];
    }

    protected function _star_is_in_1_1_queue_json($star)
    {
        $res = false;
        if (Auth::check()) {
            $is_in_1_1_queue =  user_1_1_chat_request::user_star_requests( Auth::user(),$star
                ,['ENQUEUED','WAITING','LIVE']);

            $res = $is_in_1_1_queue->count()>0;
        }
        return $res;
    }

    protected function _star_is_subscription_json(star $star)
    {
        if(Auth::check())
        {
            $is_subscription = user_subscribe::is_user_subscription($star->id ,Auth::user()->id );
            return $this->_user_subscription_json($is_subscription, [
                'star_social_media' => true
                ,'sub_media_star' => $star->id
                ,'subscription_details' => true
            ]);

        }

        return null ;

    }

    protected function _star_is_favorite_json($star)
    {
        if (Auth::guest()) {
            return false;
        }
        return user_notify_online::is_user_notify($star->id, Auth::user()->id) ? true : false;
    }

    protected function _star_media_purchase_json($star,$in = [] )
    {
        $in += ['user'=>Auth::user()] ;

        $media_purchase = media_purchase::get_star($star, $in );
        if (!$media_purchase) {
            return [];
        }

        $is_owner = false;
        $is_subscribed = false;
        if (Auth::user())
        {
            $is_owner = ((Auth::user()->star_id) == $star->id);
            $is_subscribed = user_subscribe::is_user_subscription($star->id,Auth::user()->id,'MEDIA');
        }

        $res = [];
        foreach ($media_purchase as $mp) {
            if (!empty($in['is_mobile']) && ($mp->credits_price > 0) && !$is_owner && !$is_subscribed) {
                continue;
            }

            $params = ['info'=> true];

            if ($mp->credits_price < 1 || $is_owner || $is_subscribed){
                $params['access'] = true;
            }

            if (!empty($in['purchase_count'])) {
                $params['purchase_count'] = true;
            }

            $res[] = $this->_media_purchase_json($mp, $params);
        }

        return $res;
    }

    protected function _star_media_purchase_count($star,$in = [] )
    {
        $count = 0;

        $in += ['user'=>Auth::user()] ;

        $media_purchase = media_purchase::get_star($star, $in );

        if (!$media_purchase) {
            return 0;
        }

        $is_owner = false;
        $is_subscribed = false;
        if (Auth::user())
        {
            $is_owner = ((Auth::user()->star_id) == $star->id);
            $is_subscribed = user_subscribe::is_user_subscription($star->id,Auth::user()->id,'MEDIA');
        }



        foreach ($media_purchase as $mp) {
            if (!$mp->item->count() || (!empty($in['is_mobile']) && ($mp->credits_price > 0) && !$is_owner &&
                    !$is_subscribed)) {
                continue;
            }

            $params = ['info'=> true];

            if ($mp->credits_price < 1 || $is_owner || $is_subscribed){
                $params['access'] = true;
            }

            $count++;
        }



        return $count;
    }

    protected function _star_featured_media_purchase_json($star,$access = false)
    {
        $media_purchase = media_purchase::get_star_featured($star, ['user'=>Auth::user()]);

        if (!$media_purchase) {
            return [];
        }

        $res = [];
        foreach ($media_purchase as $mp) {
            if (!$mp->item->count()) {
                continue;
            }
            $in = ['info' => true];
            $user = Auth::user();
            if ($user && !($user->star_id)){
                if (!is_null(user_subscribe::is_user_subscription($mp->star_id,$user->id,'MEDIA'))){
                    $in['subscribed']=true;
                    $in['access']=true;
                } elseif ( user_media_purchase::is_purchased($mp->id,$user->id) || $access ){
                    $in['access']=true;
                }
            } elseif ($access){
                $in['access']=true;
            }
            $res[] = $this->_media_purchase_json($mp, $in );
        }

        return $res;
    }

    protected function _media_purchase_json($media_purchase, $input = [])
    {
//		log::debug("In _media_purchase_json \$media_purchase and \$input = ".print_r($input,true));
//		log::debug(print_r($media_purchase,1));
        $res = [
            'id' => $media_purchase->id,
        ];

        $purchases = user_media_purchase::where('media_purchase_id', '=', $media_purchase->id)
            ->count();
        if (!empty($input['info'])) {
            $res += [
                'name' => $media_purchase->name,
                'description' => $media_purchase->description,
                'credits_price' => $media_purchase->credits_price,
                'type' => $media_purchase->type,
                'sale_type' => $media_purchase->sale_type,
                'duration' => $media_purchase->duration,
                'hashtags' => $media_purchase->hashtags,
                'pinned' => ($media_purchase->pinned_at)!=('0000-00-00 00:00:00')
                    ?strtotime($media_purchase->pinned_at):0,
                'published' => strtotime($media_purchase->created_at),
                'likes' => $media_purchase->likes,
                'views' => $media_purchase->views,
                'purchases' => $purchases,
                'posts' => $media_purchase->posts,
                'subscription_tier_id' => 0,
                'approval' => $media_purchase->status,
                'is_liked_by_user' => $media_purchase->is_liked_by_user,
                'all_premium_access' => $media_purchase->all_premium_access,
                'thumb' => [
                    ['width' => 500,
                        'height' => 500,
                        'url' => $media_purchase->thumb_url([500, 500])],
                    ['width' => 1000,
                        'height' => 1000,
                        'url' => $media_purchase->thumb_url([1000, 1000])],
                ],
            ];

            $subscription_tier_media = star_subscribe_media::where('media_purchase_id', $media_purchase->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            if ($subscription_tier_media) {
                $res['subscription_tier_id'] = $subscription_tier_media->master_subscribe_id;
            }

            $media_status = media_purchase_item_pending::where('media_purchase_id', '=', $media_purchase->id)->first();
            if ($media_status && $media_status->status == 'PROCESSING') {

                // Send DRAFT flag to front-end when still processing
                $res['status'] = 'DRAFT';
            }
            else {
                $res['status'] = 'PUBLISHED';
            }

            if (empty($media_purchase->type)) {
                $star_post_version = star_post_version::where('media_purchase_id',  '=', $media_purchase->id)
                    ->where('type', '=', 'TEXT')
                    ->first();
                if ($star_post_version) {
                    $res['type'] = $star_post_version->type;

                    $star_post = star_post::where('id', '=', $star_post_version->star_post_id)->first();
                    if ($star_post) {
                        $res['post_access'] = $star_post->access_type;
                    }

                }

            }

            if (empty($res['description'])) {
                $star_post = star_post_version::where('media_purchase_id', $media_purchase->id)
                    ->where('status', '=', 'PUBLISHED')
                    ->first();
                if ($star_post) {


                    // Send either summary or text field, which ever is not empty
                    // Front-end has incorrectly placed post descriptions in both fields
                    if (strlen(trim($star_post->summary))) {
                        $res['description'] = $star_post->summary;
                    }
                    if (strlen(trim($star_post->text))) {
                        $res['description'] = $star_post->text;
                    }


                }
            }

            if ($media_purchase->credits_price > 0) {
                $res += ['for_sale' => $media_purchase->for_sale];
            }
            if (Auth::user() && Auth::user()->star_id) {
                if ($media_purchase->credits_price > 0) {
                    $star_id = Auth::user()->star_id;
                    $star_subs = $this->_star_subscriptions_json($star_id);
                    if ($res['all_premium_access'] === 'YES') {
                        $subscription_required = $this->_base_premium_subscription($star_subs);
                    } else {
                        $subscription_required = $this->_subscription_required_for_media_id($media_purchase->id,
                            $star_subs);
                    }
                    if ($subscription_required) {
                        $res['total'] = $this->_sub_total_count($subscription_required['id']);
                    } else {
                        $res['total'] = 0;
                    }

                }
                else {
                    $res['total'] = 0;
                }
            }

            if ($media_purchase->type == 'AUDIO') {

                $preview_duration = 30;
                if ($media_purchase->duration * 0.15 < $preview_duration) {
                    $preview_duration = $media_purchase->duration * 0.15;
                }

                foreach ($media_purchase->item as $item) {
                    if ($item->type == 'AUDIO' && $item->duration <= $preview_duration) {
                        $res += ['preview_url' => $item->download_url];
                        $res += ['preview_duration' => $item->duration];
                        break;
                    }
                }
            }
        }

        if ( !empty($input['access']))
        {
            if ( !empty($input['owner']))
            {
                $res['items_pending_cnt'] = $media_purchase->item_pending_cnt;
                $res['for_sale']          = $media_purchase->for_sale;
            } elseif ( !empty($input['subscribed']))
            {
                $res['subscribed'] = true;
            } else
            {
                if( empty($input['wall']) || !empty($input['purchased']))
                {
                    $res['purchased'] = true;
                }


            }

            if(!empty($input['purchased']) && ($media_purchase->credits_price > 0)){
                $res['purchased'] = true;
            }



            $items = [];

            // Send down soft deleted media if calling from purchased content page
            // ( sets the with_trashed param ) in the library call
            if ($media_purchase->item->count() || !empty($input['with_trashed']));
            {
                // For deleted media, do an extra query with `withTrashed()` to get
                // soft deleted media items
                if ($media_purchase->deleted_at != null && !empty($input['with_trashed'])) {
                    $result = media_purchase_item::where('media_purchase_id', '=', $media_purchase->id)->withTrashed()->get();
                    if (count($result)) {
                        // Set items to the trashed items
                        $media_purchase->item = $result;

                        // Restore the post type from first item in results
                        $res['type'] = $result[0]->type;

                        // Restore post thumb from first item in results
                        $res['thumb'] = [
                            ['width' => 500,
                                'height' => 500,
                                'url' => $result[0]->thumb_url([500, 500])],
                            ['width' => 1000,
                                'height' => 1000,
                                'url' => $result[0]->thumb_url([1000, 1000])],
                        ];
                    }
                }
                foreach ($media_purchase->item as $item)
                {
                    $width = $height = 0;
                    if (strpos($item->dimension ,'x') !== false)
                    {
                        list($width ,$height) = explode('x' ,$item->dimension);
                    }
                    $items[] = [
                        'id'           => $item->id ,
                        'name'         => $item->name ,
                        'description'  => $item->description ,
                        'mime'         => $item->mime ,
                        'duration'     => $item->duration ,
                        'width'        => (integer)$width ,
                        'height'       => (integer)$height ,
                        'type'         => $item->type ,
                        'thumb'        => [
                            ['width'  => 500 ,
                                'height' => 500 ,
                                'url'    => $item->thumb_url([500 ,500])] ,
                            ['width'  => 1000 ,
                                'height' => 1000 ,
                                'url'    => $item->thumb_url([1000 ,1000])] ,
                        ] ,
                        'download_url' => $item->download_url ,
                        'playlist_url' => $item->vod_playlist_url ,
                    ];
                }
            }
            $error_count = media_purchase_item_pending::where('media_purchase_id', '=', $media_purchase->id)->first();
            if ($error_count && $error_count->error_cnt == 3) {
                $items[0] = "ERROR";
            }
            $res['items'] = $items;
        }

        if (!empty($input['star'])) {
            $star_in = [
                'profile'=>true
                ,'category'=>true
                ,'is_subscription'=>true
                ,'subscriptions'=>true
                ,'is_contact'=>true
                ,'rates'=>true
            ];
            if (!empty($input['no_featured_video_details'])){
                $star_in['no_video_details'] = true;
            }
            if (!empty($input['live_thumb'])){
                $star_in['thumb']=true;
            }
            $res['star'] = $this->_star_json($media_purchase->star, $star_in);
        }

        return $res;
    }

    protected function _subscription_contains_media($subscription, $media_id) {
        if ($subscription && $subscription['media'] && count($subscription['media'] > 1)) {
            $j = count($subscription['media']);
            for ($i = 0; $i < $j; $i++) {
                if ($subscription['media'][$i] === $media_id) {
                    return true;
                }
            }
        }
    }

    protected function _subscription_required_for_media_id($media_id, $subscriptions) {
        $subscription = $this->_base_premium_subscription($subscriptions);
        if ($subscriptions) {
            usort($subscriptions, function($a, $b) {
                if ($a['credits_price'] === $b['credits_price']) {
                    return 0;
                }
                return $a['credits_price'] < $b['credits_price'] ? -1 : 1;
            });

            $sortedSubscriptionsArray = $subscriptions;
            // find the lowest priced subscription that contains the $media_id
            $j = count($sortedSubscriptionsArray);
            for ($i = 0; $i < $j; $i++) {
                $sub = $sortedSubscriptionsArray[$i];
                if ($this->_subscription_contains_media($sub, $media_id)) {
                    $subscription = $sub;
                    break;
                } else {
                    $subscription = null;
                }
            }
        }
        return $subscription;
    }

    protected function _base_premium_subscription($subscriptions) {
        $subscription = null;
        $subs_length = count($subscriptions);
        for ($i = 0; $i < $subs_length; $i++) {
            $sub = $subscriptions[$i];
            if ($sub['type'] === 'MEDIA') {
                if ($sub['id'] <= 33) {
                    $subscription = $sub;
                    break;
                }
                if (!$subscription) {
                    $subscription = $sub;
                } else {
                    if ($sub['credits_price'] < $sub['credits_price']) {
                        $subscription = $sub;
                    }
                }
            }
        }
        return $subscription;
    }



    protected function _star_post_json($star_post, $input=[]){
        // Log::debug("In _star_post_json with \$star_post = ".print_r($star_post,true));

        $post = $star_post;
        $version_record = $star_post->version_record;
        $medium = isset($input['medium'])?$input['medium']:$star_post->medium;
        $star = $star_post->star;

        $user = Auth::user();
        if($user) {
            $likes_this = user_post_likes::is_liked([
                'user_id'=> $user->id
                ,'star_id'=> $star->id
                ,'star_post_id'=>$star_post->id
            ]);
        }


        // Get post_summary from star_post_version and add it to res
        $summary = star_post_version::where('id',$star_post->star_post_version_id)->first();

        $res =[
            'post_id'=>$star_post->id
            , 'post_views'=>$star_post->views
            , 'is_liked'=>$likes_this
            , 'post_is_liked'=>$likes_this
            , 'post_text_content'=> $version_record->text
            , 'post_date'=> date("F d, Y", strtotime($version_record->created_at))
            , 'post_raw_date'=> strtotime($version_record->created_at)
            , 'creator_thumb'=> $star->profile_v1_image()
            , 'creator_profile_name'=>$star->profile_name
            , 'post_headline'=> $version_record->title
            , 'post_access'=> $star_post->access_type
            , 'post_media_content'=>''
            , 'post_media_thumb'=>''
            , 'post_status'=>$star_post->status
            , 'post_summary'=>$summary->summary
            , 'post_comments_permission'=>$star_post->comments
            , 'post_comments_level'=>$star_post->comments_level
            , 'post_weight'=>$star_post->weight
            , 'post_type'=>$star_post->type
            , 'post_likes'=>$star_post->likes
        ];

        if (!empty($input['star'])) {
            $star_in = [
                'profile'=>true
                ,'category'=>true
                ,'is_subscription'=>true
                ,'subscriptions'=>true
                ,'is_contact'=>true
                ,'rates'=>true
            ];
            if (!empty($input['no_featured_video_details'])) {
                $star_in['no_video_details'] = true;
            }
            if (!empty($input['live_thumb'])){
                $star_in['thumb']=true;
            }
            $res['star'] = $this->_star_json($star, $star_in);
        }

        if ($medium) {
            $flags = ['wall'=>true, 'info'=>true]+$input;
            if (isset($flags['star'])){
                unset($flags['star']);
            }
            $res['post_media_content']=$this->_media_purchase_json($medium ,$flags);
            $res['post_media_thumb']=$medium->thumb_url;
        }

        if ($star_post->comments_records){
            $res['post_comments'] = $this->_post_comments_json($star_post->comments_records);
        }

        if (isset($post['comments']) && $star_post->comments != 'NO_COMMENTS'){
            $res['post_comments'] = $this->_post_comments_json($post['comments']);
        }

        if (isset($input['access_types'])){
            $res['post_this_user_access']= implode(',',$input['access_types']);
        }

        return $res;
    }

    protected function _post_comments_json($post_comments, $input = [])
    {

        /* TODO: Flush this out when we support comments on posts*/
        $post=null;
        $res = [
            'id' => $post->id,
        ];

        return $res;
    }

    protected function _star_user_media_subscribe_json($star,$input)
    {
        if (!Auth::check()) {
            return [];
        }
        if (!user_subscribe::is_user_subscription($star->id, Auth::user()->id, 'MEDIA')) {
            return [];
        }
        $media_purchase = media_purchase::get_star($star,$input);

        if (!$media_purchase) {
            return [];
        }

        $res = [];
        foreach ($media_purchase as $mp) {
            if (!$mp->item->count()) {
                continue;
            }
            $res[] = $this->_media_purchase_json($mp, [
                'access' => true,
                'subscribed' => true,
            ]);
        }
        return $res;
    }

    protected function _star_user_media_purchase_json($star,$input=[])
    {
        $media_purchase = media_purchase::get_star($star,$input);

        if (!$media_purchase) {
            return [];
        }
        if (Auth::check()) {
            $media_purchase_own = user_media_purchase::get_purchased($media_purchase, $star, Auth::user());
        } else {
            $media_purchase_own = [];
        }

        $res = [];
        foreach ($media_purchase as $mp) {

            // Log::debug("checking media_purchase_item ".print_r($mp,true));
            if (!$mp->item->count() ) {
                continue;
            }
            if (!empty($media_purchase_own[$mp->id]) ) {
                $res[] = $this->_media_purchase_json($mp, [
                    'access' => true,
                ]);
            } else {
                if (empty($input['is_mobile']))
                {
                    $res[] = [
                        'id'        => $mp->id ,
                        'purchased' => !empty($media_purchase_own[$mp->id]) ,
                    ];
                }
            }
        }
        return $res;
    }

    protected function _star_live_stream_json($star)
    {
        if (!Auth::check()) {
            return null;
        }
        $star_chat_show = star_chat_show::get_current_show($star->id);
        $live_stream = null;
        if ($star_chat_show) {
            $live_stream = [
                'id' => $star_chat_show->id,
                'type' => $star_chat_show->show_type,
                'description' => $star_chat_show->description,
                'title' => $star_chat_show->title,
                'credits_price' => $star_chat_show->credits_price,
                'started_at' => ApiUtils::time($star_chat_show->started_at),
                'is_online' => $star->status != 'OFFLINE',
            ];
            $access = false;
            if (admin_log::is_chat_banned(Auth::user()->id)
                || star_block::is_chat_blocked($star->id, Auth::user()->id)) {
                //no access
            } else {
                //need to make sure a $user_chat_show obj exists, otherwise we aren't logging every user who joins a show via API, this means all API users need to call the /star/{star_id}/join_stream endpoint for all types of shows
                $user_chat_show = user_chat_show::get_user_show($star_chat_show->id, Auth::user()->id);
                $access = $user_chat_show && $star_chat_show->show_joined(Auth::user(), '', $user_chat_show);
            }
            if ($access) {
                $claims = [
                    'userId' => Auth::user()->id,
                    'roomName' => 'star_' . $star->id,
                    'username' => Auth::user()->username,
                ];
                $token = ChatAuth::userToken($star_chat_show->id, $star->profile_name, $star->profile_name, Auth::user()->id, $claims);
                $stream = $star_chat_show->cdn_url($token);

                $live_stream['access'] = [
                    'is_access' => true,
                    'streams' => ['cdn' => $stream],
                    'token' => $token,
                    'chat' => [
                        'host' => \WhiteLabel::chat('ws_host'),
                        'token' => $token,
                        'room' => $star_chat_show->chat_room(),
                    ],
                ];
            }
            if ($star_chat_show->show_gift == 'Y' || $star_chat_show->show_type == 'GIFT') {
                $gift = $star_chat_show->get_gift();
                if ($gift) {
                    $live_stream['gift'] = [
                        [
                            'credits_price' => $gift->amount_1,
                            'icon' => $gift->icon_url_1,
                        ],
                        [
                            'credits_price' => $gift->amount_2,
                            'icon' => $gift->icon_url_2,
                        ],
                        [
                            'credits_price' => $gift->amount_3,
                            'icon' => $gift->icon_url_3,
                        ],
                        [
                            'credits_price' => $gift->amount_4,
                            'icon' => $gift->icon_url_4,
                        ],
                    ];
                    $live_stream['has_gifted'] = star_chat_gift::has_gifted($star_chat_show, Auth::user()) ? true : false;
                }
            }
            if (empty($live_stream['gift'])) {
                $live_stream['gift'] = null;
                $live_stream['has_gifted'] = null;
            }
            $star_button = star_button::get_current_button($star->id);
            if ($star_button) {
                $live_stream['buy_button'] = [
                    'title' => $star_button->text,
                    'url' => $star_button->url,
                ];
            } else {
                $live_stream['buy_button'] = null;
            }
        }
        return $live_stream;
    }

    protected function _star_message_default($star, $created_at, $user)
    {


        $body_star = message::get_network_origin_label($user, $star) . message::text('new_network_user',
                ['star_profile_name' => $star->profile_name], false);

        return [
            'direction' => 'TO',
            'body' => $body_star,
            'media' => null,
            'sent_time' => ApiUtils::time($created_at),
        ];
    }

    protected function _user_json($user ,$input = [])
    {
        if ( !$user)
        {
            return [];
        }

        //Log::debug("_user_json: " . print_r($user,true));

        $out = [
            'id'       => $user->id ,
            'username' => $user->username ,
        ];

        if ( !empty($input['display_name']))
        {
            $name = $user->display_name;
            if (empty($name)) {
                $name = $user->email_name;
            }
            $out['display_name'] = $name;
        }

        if (!empty($input['star_social_media'])) {
            $out['star_social_media'] = $user->display_name;
        }

        if ( !empty($input['is_contact']))
        {
            $is_contact = $contact_number = null;
            $contact_site_id = 3;

            if (Auth::check())
            {
                $is_contact = user_network::is_user_network(Auth::user()->star_id ,$user->id);
                if ($is_contact)
                {
                    $contact_number =
                        $this->_twilio()->get_number_intl($user->id, $user->star_id, Auth::user()->country_code);

                    $contact_site_id = $is_contact->site_id;
                }
            }

            $active_until = null;
            if ( !empty($is_contact))
            {
                $active_until = $is_contact->active_until_timestamp;
            }

            $out += [
                'contact_number' => $contact_number,
                'is_contact' => !empty($is_contact),
                'contact_active_until' => ApiUtils::time($active_until),
                'contact_site_id' => $contact_site_id
            ];
        }

        return $out;
    }

    protected function _star_social_media_json($user_sub, $input = [])
    {
        $star = $user_sub->star;
        if (!$star) {
            return [];
        }

        $out = null;

        if (!isset($input['star_social_media'])) {
            return $out;
        }

        $subscription = subscribe::where(['id' => $user_sub->subscribe_id])->first();

        if (!$subscription) {
            return $out;
        }

        $star_social_media_service = star_social_media_name::where([
            'star_id' => $star->id
        ])->get();

        foreach ($star_social_media_service as &$service) {
            $subscription_services = explode(",", $subscription->social_media_names);
            if (in_array($service->service, $subscription_services)) {
                $out[strtolower($service->service)] = $service->social_media_name;
            }
        }

        return $out;
    }

    protected function _user_message_default($user, $created_at, $star)
    {

        $body_user = message::get_network_origin_label($user, $star) .
            message::text('new_network_star', ['user_display_name' => $user->display_name], false);

        return [
            'direction' => 'TO',
            'body' => $body_user,
            'media' => null,
            'sent_time' => ApiUtils::time($created_at),
        ];
    }

    protected function _star($profile_name)
    {
        return star::get_from_profile_name($profile_name
            ,[
                'star_category'           => true ,
                'media'                   => true ,
                'user'                    => true ,
                'star_accounting.charity' => true ,
                'profile_image'           => ['type' => ['PROFILE' ,'PROFILE_BG' ,'PROFILE_V1']]
            ]
        );
    }

    public function login()
    {
        if (!Request::has('email') || !Request::has('password')) {
            return $this->response_fail('email & password required.');
        }

        Request::merge([
            'email' => trim(Request::get('email')),
            'password' => trim(Request::get('password')),
        ]);

        $is_star = User::where('username', '=', Request::get('email'))->where('star_id', '!=', '0')->first();
        if ($is_star) {
            return $this->response_fail('This type of account requires an email to login. Username is not allowed.');
        }

        if (!$this->auth->attempt(Request::only('email', 'password'))) {
            if (!$this->auth->attempt(['username' => Request::get('email'), 'password' => Request::get('password')])) {
                return $this->response_fail('invalid email/password');
            }
        }

        $data = ['categories' => category::lookup()->toArray()];
        return $this->response_success($data);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return $this->response_success();
    }

    protected function _star_rates_json($star_id, $additional = [])
    {
        $star_rate = star_rate::get_current_rate($star_id);

        if (!$star_rate) {
            return null;
        }

        $rates = array_intersect_key($star_rate->toArray(), [
                'receive_sms' => true,
                'send_sms' => true,
                'send_mms' => true,
                'receive_mms' => true,
                'voice_minute' => true,
                'voice_minute_min' => true,
                'create_network' => true,
                'ppm_stream' => true,
                'ppv_stream' => true,
                'bulletin' => true,
                'recorded_stream' => true,
                'vchat11'=> true,
                'vchat_1_1_minimum_duration' => true
            ] + $additional);

        return array_map(function ($rate) {
            return (integer)$rate;
        }, $rates);
    }

    protected function _star_stream_types_json($star, $additional = [])
    {

        $allowed = star_chat_show::shows_allowed($star);

        if (!is_array($allowed)) {
            $allowed = [];
        }

        $out = [
            "PPV" => in_array("PPV", $allowed)
            , "PPM" => in_array("PPM", $allowed)
            , "Gift" => in_array("GIFT", $allowed)
            , "Sponsored" => in_array("FREE", $allowed)
        ];

        return $out;
    }

    protected function _star_refer_payout_json($star, $additional = [])
    {

        // Log::debug("in _star_refer_payout_json with star_id ".$star->id);

        $payouts = star_referral_payout_log::get_by_star_id($star->id);

        $out = [];
        foreach ($payouts as $payout)
        {
            $out['payouts'][]=[
                'payout'=>$payout->payout
                ,'cumulative_payout_dollars'=>$payout->payout_cumulative
                ,'over_threshold'=>$payout->over_threshold
                ,'pay_period_start'=>$payout->payout_period
                ,'pay_period_days' =>$payout->pay_period_days
                ,'processed_on' =>$payout->processed_on

            ];

        }

        return $out;
    }

    protected function _star_referee_stats_json($referee,$in=[]){

        $star = $referee->star;
        $out=[
            'star'=>$this->_star_json($star,[
                'refer_stats'=>true
                ,'no_video_details'=>true
            ])
        ];
        return $out;
    }


    protected function _star_refer_stats_json($star, $additional = [])
    {

        // Log::debug("in _star_refer_stats_json with star_id ".$star->id);

        $star_referral_summary = new star_referral_summary;
        $referred = $star_referral_summary->referred_by($star->id);

        $out = [];
        $all_time_gross_earnings = 0;
        foreach ($referred as $referee)
        {
            // Log::debug("in _star_refer_stats_json ");
            $out['referred'][]=[
                'referred'=>$this->_star_referee_stats_json($referee,$additional)
                ,'gross'=>$referee->gross_earned_credits
                ,'cut'=>$referee->gross_referral_credits
            ];

            $all_time_gross_earnings += $referee->gross_earned_credits;
        }

        $out['all_time_gross_earnings']= $all_time_gross_earnings;

        return $out;
    }

    protected function _star_services_json($star, $additional = [])
    {

        $out = explode(',', $star->services);

        return $out;
    }


    protected function _subscription_json($subscription, $additional = [])
    {
        $out = [
            "id"                       => $subscription->id ,
            "master_subscription"      => $subscription->master ,
            "name"                     => $subscription->name ,
            "description"              => $subscription->description ,
            "credits_price"            => $subscription->credits_price ,
            "duration"                 => $subscription->duration ,
            "type"                     => $subscription->type ,
            "duration_period"          => $subscription->duration_period ,
            "custom"                   => $subscription->custom ,
            "collect_email"            => $subscription->collect_email ,
            "collect_shipping_address" => $subscription->collect_shipping_address ,
            "social_media_names"       => $subscription->social_media_names ,


        ];

        if (isset($additional['sub_media_star'])){
            $out['media'] = $this->_sub_media_star_json($subscription,$additional);
        }

        if (isset($additional['star_is_me']) && isset($additional['my_star_id'])){

            $star_social_media_service = star_social_media_name::where([
                'star_id' => $additional['my_star_id']
            ])->get();

            $subscription_services = explode(",", $subscription->social_media_names);

            foreach ($star_social_media_service as &$service) {
                if (in_array($service->service, $subscription_services)) {
                    $out[strtolower($service->service)] = $service->social_media_name;
                }
            }
            $out['total'] = $this->_sub_total_count($subscription->id);
        }

        return $out;
    }

    protected function _sub_total_count($subscription_id){
        $star_id = Auth::user()->star_id;
        $totals = 0;

        $current = user_subscribe::selectRaw('count(distinct user_id) as total')
            ->whereIn('status', ['ACTIVE', 'CANCELLED'])
            ->where('star_id', '=', $star_id)
            ->where('subscribe_id', '=', $subscription_id)
            ->first();

        if ($current->total) {
            $totals = $current->total;
        }
        return $totals;
    }

    protected function _sub_media_star_json($subscription,$additional){
        if (!isset($additional['sub_media_star'])){
            return [];
        }

        $star_id = $additional['sub_media_star'];
        $media_list = star_subscribe_media::where(
            [ 'star_id' => $star_id
                , 'master_subscribe_id' => $subscription->master_subscription
            ]
        )->get();

        $out = [];
        foreach ($media_list as $medium)
        {
            $out[] = $medium->media_purchase_id;
        }

        return $out;
    }

    protected function _star_subscriptions_json($star_id, $additional = [])
    {
        $subscriptions = star_subscribe::get_current_subscriptions($star_id);

        if (!$subscriptions) {
            return null;
        }

        $data = [];
        $additional['sub_media_star'] = $star_id;
        foreach ($subscriptions as $sub) {


            $data[] = $this->_subscription_json($sub,$additional);
        }

        // log::debug("Return subscription package ".print_r($data,true));

        return $data;
    }

    protected function _user_subscription_json($user_sub, $additional = [])
    {
        if ($user_sub) {
            $out = [
                'subscription_id' => $user_sub->subscribe_id,
                'is_active' => $user_sub->is_active,
                'credits_price' => $user_sub->credits_price,
                'duration' => $user_sub->duration_timestamp,
                'duration_str' => $user_sub->duration_str,
                'type' => $user_sub->type,
                'status' => $user_sub->status,
                'active_until' => $user_sub->is_active ? $user_sub->next_billing_timestamp : null,
                'next_billing' => $user_sub->status == 'ACTIVE' ? $user_sub->next_billing_timestamp : null,
                'cancelled_at' => $user_sub->cancelled_at_timestamp,
                'created_at' => $user_sub->created_at->timestamp,
                'contact_info' => $this->_user_subscription_contact_info_json($user_sub,$additional),
            ];
            if (!empty($additional['star'])) {
                $out['star'] = $this->_star_json($user_sub->star);
            }

            if (!empty($additional['subscription_details'])){
                $subscription = $user_sub->subscription;
                if ($subscription) {
                    $out['subscribe'] = $this->_subscription_json($subscription, $additional);
                }
            }

            if (!empty($additional['subscription_name'])){
                $subscription = $user_sub->subscription;
                $out['subscription_name']=$subscription->name;
            }

            if (!empty($additional['user'])) {
                $out['user'] = $this->_user_json($user_sub->user, $additional);
            }

            if ( !empty($additional['user_social_media_ids'])
                || !empty($additional['user_mailing_address'])
                || !empty($additional['star_social_media']) )
            {

                $subscription = subscribe::where(['id' => $user_sub->subscribe_id])->first();
                //$subscription = $user_sub->subscribe;

                if ( !empty($additional['user_social_media_ids']))
                {
                    if ($subscription)
                    {
                        $user_social_media_ids = [];
                        $services = explode(',',$subscription->social_media_names);

                        $ids = $user_sub->user_subscribe_social_media_name;
                        foreach ($ids as $id)
                        {
                            if (in_array($id->service,$services)){
                                $user_social_media_ids[$id->service] = $id->social_media_name;
                            }
                        }

                        if(count($user_social_media_ids)>0){
                            $out['user_social_media_ids'] = $user_social_media_ids;
                        }
                    }
                }

                if ( !empty($additional['user_mailing_address']))
                {
                    if ($subscription)
                    {
                        $user_contact_information = [];

                        $contact_information = $user_sub->user_subscribe_mailing_address;

                        if($contact_information)
                        {

                            if ($subscription->collect_email == 'YES' && $contact_information->email)
                            {
                                $user_contact_information['email'] = $contact_information->email;
                            }

                            if ($subscription->collect_shipping_address == 'YES')
                            {
                                $shipping_address['mailing_name'] = $contact_information->mailing_name;
                                $shipping_address['city']         = $contact_information->city;
                                $shipping_address['subdivision']  = $contact_information->subdivision;
                                $shipping_address['country']      = $contact_information->country;
                                $shipping_address['short_postal'] = $contact_information->short_postal;
                                $shipping_address['address_1']    = $contact_information->address_1;
                                $shipping_address['address_2']    = $contact_information->address_2;
                                $user_contact_information['shipping_address'] = $shipping_address;

                            }

                        }


                        if(count($user_contact_information)>0){
                            $out['user_contact_information'] = $user_contact_information;
                        }
                    }
                }




                if ( !empty($additional['star_social_media']))
                {
                    if ($subscription)
                    {
                        $out['star_social_media'] =
                            $this->_star_social_media_json($user_sub ,['star_social_media' => true]);
                    }
                }
            }

        } else {
            $out = null;
        }

        return $out;
    }

    protected function _user_subscription_contact_info_json($user_sub,$additional){
        $out = [];
        if($user_sub){
            $subscribe = $user_sub->subscription;
            if($subscribe){
                if($subscribe->collect_email == 'YES'){
                    $contact_info = $user_sub->user_subscribe_mailing_address;
                    if ($contact_info) {
                        $out['email'] = $contact_info->email;
                    }
                }

                if($subscribe->collect_shipping_address == 'YES'){
                    $contact_info = $user_sub->user_subscribe_mailing_address;
                    if ($contact_info)
                    {
                        $out += $contact_info->mailing_address;
                    }

                }
            }
        }
    }

    protected function _star_playlists_short_json($star){
        $playlists = $star->star_playlist;
        if (!$playlists){
            return null;
        }
        $playlister = [];
        foreach ($playlists as $playlist){
            $entry = $this->_playlist_summary_json($playlist);
            $playlister[] = $entry;
        }
        return $playlister;
    }

    protected function _playlist_summary_json($playlist){
        $entry = [
            'id'=>$playlist->id
            ,'name'=>$playlist->playlist_name
            ,'count'=>$playlist->playlist_count
            ,'thumb'=>$playlist->playlist_thumb
            ,'is_public'=>$playlist->playlist_is_public
            ,'created_at'=>strtotime($playlist->created_at)
            ,'media_purchase_ids' => $this->_playlist_media_purchase_ids_json($playlist)
        ];

        $all_premium_access = [];
        foreach ($entry['media_purchase_ids'] as $media_purchase_id)
        {
            $subs = star_subscribe_media::media_master_subscriptions($media_purchase_id);
            if ($subs->count()<1){
                $all_premium_access[]=$media_purchase_id;
            }
        }
        $entry['all_premium_access_ids']=$all_premium_access;
        return $entry;
    }

    protected function _playlist_json($in){
        if (!isset($in['playlist']))
            return null;
        $playlist = $in['playlist'];
        $out = [];
        if (isset($in['summary'])){
            $out['summary']=$this->_playlist_summary_json($playlist);
        }

        if (isset($in['media'])){

            $out['media']=$this->_playlist_media_purchase_json($playlist, $in);
        }

        if (isset($in['media_ids'])){
            $out['media']=$this->_playlist_media_purchase_ids_json($playlist,$in);
        }


        return $out;
    }


    protected function _playlist_media_purchase_json($playlist,$in = [] )
    {
        $in += ['user'=>Auth::user()] ;
        $in += ['info' => true];

//		Log::debug("In _playlist_media_purchase_json with \$playlist = ".print_r($playlist,true));
//		Log::debug("In _playlist_media_purchase_json with \$in = ".print_r($in,true));

        $media_list = $playlist->media_playlist;

        $media_purchase=[];

        foreach ($media_list as $media_playlist){
            $media_purchase[]=$media_playlist->media_purchase;
        }

        if (!$media_purchase) {
            return [];
        }

        $check_purchase = !isset($in['access']);
        $res = [];
        foreach ($media_purchase as $mp) {
            if (!$mp->item->count()) {
                continue;
            }
            $mods = $in;
            if ($check_purchase && (($mp->credits_price == 0) || user_media_purchase::is_purchased($mp->id, $in['user']->id))){
                $mods+=[
                    'access'=>true
                    ,'purchased'=>true
                ];
            }

            if (isset($mods['hide_no_access']) && !isset($mods['access']) ){
                continue;
            }
            $res[] = $this->_media_purchase_json($mp,$mods );
        }

        return $res;
    }

    protected function _playlist_media_purchase_ids_json($playlist)
    {

//		Log::debug("In _playlist_media_purchase_json with \$playlist = ".print_r($playlist,true));
//		Log::debug("In _playlist_media_purchase_json with \$in = ".print_r($in,true));

        $media_list = $playlist->media_playlist;

        $media_purchase_ids = [];

        foreach ($media_list as $media_playlist) {
            $media_purchase_item = media_purchase_item::where('media_purchase_id', $media_playlist->media_purchase_id)->first();
            if ($media_purchase_item) {
                $media_purchase_ids[] = $media_playlist->media_purchase_id;
            }
        }

        return $media_purchase_ids;
    }



    public function chat_history($star_id)
    {
        // Just make sure star exists
        $star = $this->_star($star_id);
        if (!$star) {
            return $this->response_fail('not found');
        }

        $redis = Redis::connection('chat');

        $chat = $redis->lrange($star->profile_name . '_history', 0, 99);

        foreach ($chat as $key => $value) {
            $chat[$key] = json_decode($value);
        }

        return $this->response_success(['history' => $chat]);
    }

    public function chat_filter($star_id)
    {
        $star = $this->_star($star_id);

        if (!$star) {
            return $this->response_fail('not found');
        }

        if (!$star->star_chat_filter_id) {
            return $this->response_success(['filter' => null]);
        }

        $filter = [
            'service' => $star->star_chat_filter->filter_service,
            'service_id' => $star->star_chat_filter->filter_id,
        ];

        return $this->response_success(['filter' => $filter]);
    }

    public function chat_status($show_id)
    {
        $show = star_chat_show::where('id', '=', $show_id)
            ->first();
        if (!$show) {
            return $this->response_fail('show not found');
        }
        return $this->response_success(['status' => $show->state]);
    }

    protected function _twilio()
    {
        static $twilio = null;
        if ($twilio === null) {
            $twilio = new twilio;
        }
        return $twilio;
    }

    protected function response_success()
    {
        //disconnect from master, keep connection count low
        DB::disconnect();
        return ApiUtils::response_success(...func_get_args());
    }

    protected function response_success_json()
    {
        //disconnect from master, keep connection count low
        DB::disconnect();
        return ApiUtils::response_success_json(...func_get_args());
    }

    protected function response_fail()
    {
        //disconnect from master, keep connection count low
        DB::disconnect();
        return ApiUtils::response_fail(...func_get_args());
    }

    protected function response_fail_data()
    {
        //disconnect from master, keep connection count low
        DB::disconnect();
        return ApiUtils::response_fail_data(...func_get_args());
    }

    public function test()
    {
        return view('test/api', []);
    }

    public function login_stream_jwt()
    {
        if (!Request::has('email') || !Request::has('password') || !Request::has('star_id')) {
            return $this->response_fail('email & password & star_id required.');
        }
        $star = $this->_star(Request::get('star_id'));
        if (!$star) {
            return $this->response_fail('star not found');
        }
        $show = star_chat_show::get_current_show($star->id);
        if (!$show) {
            return $this->response_fail('show doesn\'t exist for this star');
        }
        if (!$this->auth->attempt(Request::only('email', 'password'))) {
            if (!$this->auth->attempt(['username' => Request::get('email'), 'password' => Request::get('password')])) {
                return $this->response_fail('invalid email/password');
            }
        }
        $claims = [
            'userId' => Auth::user()->id,
            'roomName' => 'star_' . $star->id,
            'username' => Auth::user()->username,
        ];
        $token = ChatAuth::userToken($show->id, $star->profile_name, $star->profile_name, Auth::user()->id, $claims);
        return $this->response_success([
            'token' => $token,
            'star' => $this->_star_json($star),
        ]);
    }

    public function remove_test_user($id = null)
    {
        $user_ids = [];
        if ($id) {
            $user_ids = explode(',', $id);
        } else if (Request::has('user_id')) {
            $user_ids = Request::get('user_id');
            if (!is_array($user_ids)) {
                $user_ids = explode(',', $user_ids);
            }
        } else {
            return $this->response_fail('missing user_id');
        }
        foreach ($user_ids as $i => $user_id) {
            $user_id = intval($user_id);
            if (!$user_id) {
                unset($user_ids[$i]);
            } else {
                $user_ids[$i] = $user_id;
            }
        }
        while (count($user_ids)) {
            $tmp_ids = array_splice($user_ids, 0, 1000);
            $users = user::whereIn('id', $tmp_ids)->get();
            $users = $users->reject(function ($user) {
                return stripos($user->email, 'collidetesting.com') === false;
            });
            foreach ($users as $user) {
                $user->delete();
            }
        }
    }

    public function version()
    {
        $required = [];

        $client_required = unserialize(config::key('min_client_version_required'));

        $required['android'] = (float)($client_required['android'] ?? 0.1);
        $required['ios'] = (float)($client_required['ios'] ?? 0.1);

        $out = [
            'version' => \WhiteLabel::config('api_v1')->version,
            'time' => \WhiteLabel::config('api_v1')->time,
            'min_client_version' => $required,
        ];

        return $this->response_success($out);
    }

    public function star_report($star_id, Request $request)
    {
        $star = $this->_star($star_id);

        if (!$star) {
            return $this->response_fail('not found', 404);
        }

        if (!Request::get('description')) {
            return $this->response_fail('Missing report description');
        }

        star_report::create([
            'star_id' => $star->id,
            'user_id' => Auth::check() ? Auth::user()->id : 0,
            'description' => Request::get('description'),
        ]);

        return $this->response_success();
    }

    public function media_report($id)
    {
        $media_purchase = media_purchase::withTrashed()->find($id);

        if (!$media_purchase) {
            return $this->response_fail('Media not found', 404);
        }

        if (!Request::get('description')) {
            return $this->response_fail('Missing report description');
        }

        $status = "REPORTED";

        $report_summary = media_purchase_report::summary($id);

        if ($report_summary['count']>0){
            $status = $report_summary['status'];
            if ($report_summary['status']=='REPORTED' && $report_summary['count']>9){
                $media_purchase->delete();
            }

        } else {
            $status = 'REPORTED';
        }


        media_purchase_report::create([
            'media_purchase_id' => $media_purchase->id
            ,'user_id' => Auth::check() ? Auth::user()->id : 0
            ,'description' => Request::get('description')
            ,'status' => $status
        ]);

        return $this->response_success();
    }

    // Moved from UserController so star can hit this.

    public function star_me($star_id) {
        $star = $this->_star($star_id);

        if (!$star) {
            return $this->response_fail('not found', 404);
        }

        // Determine media department
        $department = 'LIBRARY';
        if (Request::has('department') && is_string(Request::get('department'))){
            if(in_array(Request::get('department'),\WhiteLabel::config('media')->media_departments))
            {
                $department = Request::get('department');
            } else {
                return $this->response_fail("Invalid department name.");
            }
        }

        return $this->response_success(['star' => $this->_star_json($star, [
                'is_contact' => true,
                'is_favorite' => true,
                'is_subscription' => true,
                'user_media_subscribe' => true,
                'user_media_purchase' => true,
                'live_stream' => true,
                'stream_types' => true,
                'services' => true,
                'department' => $department,
                'is_in_1_1_queue' => true,
            ])]
            ,200
            ,['cache_control'=>'max-age=1'])
            ;
    }

    /**
     * A combination of star/id/me and star/id
     *
     * @param $star_id
     * @return mixed
     */
    public function star_me_detail($star_id) {
        $star = $this->_star($star_id);

        $in = [];

        if(Request::has('mobile')){
            $in['is_mobile']=true;
        }

        if (!$star) {
            return $this->response_fail('not found', 404);
        }

        // Determine media department
        $department = 'LIBRARY';
        if (Request::has('department') && is_string(Request::get('department'))){
            if(in_array(Request::get('department'),array_merge(['ALL'],\WhiteLabel::config('media')
                ->media_departments)))
            {
                $department = Request::get('department');
            } else {
                return $this->response_fail("Invalid department name.");
            }
        }
        $in += [
            'is_contact' => true,
            'is_favorite' => true,
            'is_subscription' => true,
            'user_media_subscribe' => true,
            'user_media_purchase' => true,
            'live_stream' => true,
            'stream_types' => true,
            'services' => true,
            'profile' => true,
            'department' => $department,
            'category' => true,
            'media_purchase' => true,
            'rates' => true,
            'subscriptions' => true,
            'playlists'=>true

        ];

        return $this->response_success(['star' => $this->_star_json($star, $in)]
            ,200
            ,['cache_control'=>'max-age=1'])
            ;
    }

    public function playlist_media (Request $request, $playlist_id){
        // log::debug("In playlist_media with \$playlist_id = $playlist_id");
        // log::debug("In playlist_media with \$request = ".print_r(Request::all(),true));
        if (!Auth::check())
        {
            return $this->response_fail("You must be logged in.");
        }

        $playlist = star_playlist::where('id',$playlist_id)->first();
        // log::debug("In playlist_media with \$playlist = ".print_r($playlist  ,true));


        $user = Auth::user();

        if (!$playlist){
            return $this->response_fail ("Invalid playlist id");
        }

        $in = [
            'playlist'=>$playlist
            ,'summary'=>true
            ,'media'=>true
        ];
        if (Request::has('mobile')){
            $in += [ 'hide_no_access'=>true];
        }


        if ($playlist->star_id == $user->star_id){
            $in+=[
                'access'=>true
                ,'owner'=>true
            ];
        } elseif (user_subscribe::is_user_subscription($playlist->star_id,$user->id,'MEDIA')){
            $in['subscribed']=true;
            $in['access']=true;
        }
        // log::debug("In playlist_media with \$in = ".print_r($in  ,true));

        $out= $this->_playlist_json($in);
        return $out;
    }

    public function media_view($id) {

        if (!Auth::check()){
            return $this->response_fail("You must be logged in to count a view");
        }
        $media_purchase = media_purchase::where('id',$id)->first();
        if (!$media_purchase) {
            return $this->response_fail('not found', 404);
        }

//		log::debug("In media_view with \$id = $id and \$media_purchase = ".print_r($media_purchase,true));

        $media_purchase->view();

        $media_purchase->save();

        return $this->response_success(['views'=>$media_purchase->views]);
    }


}

