<?php namespace App\Services;

use App\Models\chat;
use App\notify_in_app;
use App\one_on_one_site;
use App\star_subscribe;
use App\subscribe;
use App\site;
use App\user_1_1_chat_request;
use App\user_network;
use App\user_notify_online;
use App\user_subscribe;
use App\user_subscribe_webpush;
use Exception;
use App\Models\User;
use App\star;
use App\star_rate;
use App\message;
use Illuminate\Support\Facades\Auth;
use Log;
use App\Services\WebUtils;
use App\Phone\twilio;
use App\user_message_log;
use App\user_mobile_num;
use Config;


class NotificationUtils  {

    const NAME_VCHAT_EXPIRED = 'vchat_expired_notify';
    const NAME_SMS_AVAILABLE = 'connect_sms_available';
    const NAME_PHONE_AVAILABLE = 'connect_phone_available';
    const NAME_VCHAT_AVAILABLE = 'connect_1_1_video_chat_available';
    const NAME_SMS_PRICE_CHANGE = 'price_send_sms_notify';
    const NAME_MMS_PRICE_CHANGE = 'price_send_mms_notify';
    const NAME_VOICE_PRICE_CHANGE = 'price_voice_minute_notify';
    const NAME_VCHAT_PRICE_CHANGE = 'price_vchat11_notify';
    const NAME_SUB_PURCHASE = 'sub_purchase_notify';
    const NAME_SUB_TIER_DELETE = 'sub_tier_delete_notify';
    const NAME_STAR_JOINED = 'star_joined_notify';
    const NAME_STAR_RESCHEDULED = 'star_rescheduled_notify';
    const NAME_USER_ACCEPT_RESCHEDULED = 'user_accept_rescheduled_notify';
    const NAME_STAR_ACCEPT_SCHEDULED = 'star_accept_scheduled_notify';
    const NAME_NEW_UNFOLLOW_NOTIFY = 'star_new_unfollow_notify';
    const NAME_NEW_FOLLOW_NOTIFY = 'star_new_follow_notify';
    const NAME_VCHAT_REQUESTED = 'vchat_requested_notify';
    const NAME_NEW_SUBSCRIBER = 'star_new_subscriber_notify';
    const NAME_SUCCESS_HACKS = 'success_hack_notify';
    const NAME_MISSING_BANKING_INFO = 'star_missing_bank_info_notify';

	/**
	 * Email and sms notification sent to a user when star accepts
	 * their 1-1 video chat request.
	 *
	 * @return true if message sent, false if there was an error.
	 *
	 * @param $user   A user object
	 * @param $star   A star object
	 * @param $star_user  The user object for the star (to get contact information)
	 */


	public static function vchat_1_1_star_joined($user, $star, $star_user){
        
//        Log::debug("In vchat star join with star: " . $star->profile_name);
		

                $profile_link = $star->short_url;
                $subdomain = 'www';
                if (WebUtils::dev_box()) {
                    switch ( Config::get('app.env')){
	                    case 'qa':
	                    	$subdomain = 'qa';
	                    	break;
	                    case 'development':
	                    case 'local':
	                    default:
	                    	$subdomain = 'qa';
	                    	break;
                    }
                }
		$profile_link = $subdomain.".collide.com".$profile_link;
		// Get star profile url
        $profile_link = $star->full_url;
        if (WebUtils::dev_box()) {
            $profile_link = "https://qa.collide.com" . $star->url;
        }
        $message = $star->profile_name . " has accepted your request!! Click here to Video" .
            " Chat now: ".$profile_link . "?vchat=1";

        self::notify($user->id, $message, self::NAME_STAR_JOINED);



        $subject = $star->profile_name . " accepted! Video Chat Now!";
        $body = [ 
            "Good news! " . $star->profile_name . " has accepted your request!! Click here to " .
                                               "Video Chat now: ".$profile_link . "?vchat=1",
            "",
            "For questions, please contact support@collide.com",
            "",
            "Team Collide"
        ];
        $body = implode("\n", $body);
        
        $mail = [
            'email' => $user->email,
            'body' => $body,
            'subject' => $subject
        ];
		
		CacheUtils::append('cron_mailer:1_1_vchat',$mail);
		
		return true;
	}


	public static function vchat_1_1_star_rescheduled($user, $star) {

	    // This should be set in `Star::full_url`, shouldn't it?
        $profile_link = WebUtils::dev_box() ? "https://qa.collide.com" . $star->url : $star->full_url;
        $message = $star->profile_name . " has rescheduled your chat. Click here to accept/decline: ".$profile_link;

        self::notify($user->id, $message, self::NAME_STAR_RESCHEDULED);


        $subject = $star->profile_name . " has rescheduled your chat";
        $body = $star->profile_name . " has rescheduled your chat. Click here to accept/decline: " .$profile_link.
            "\n\n".
            "For questions, please contact support@collide.com\n".
            "\n".
            "Team Collide";

        $mail = [
            'email' => $user->email,
            'body' => $body,
            'subject' => $subject,
        ];

		CacheUtils::append('cron_mailer:1_1_vchat', $mail);
	}


	public static function vchat_1_1_user_accept_reschedule($user, $star, $accept) {

	    $accepted = $accept ? "accepted" : "declined";

	    // This should be set in `Star::full_url`, shouldn't it?
        $profile_link = WebUtils::dev_box() ? "https://qa.collide.com" . $star->url : $star->full_url;
        $message = $star->profile_name . " has {$accepted} your new chat time.".($accept ? " Click here to " .
                "Video Chat now: ".$profile_link . "?vchat=1":'');

        self::notify($user->id, $message, self::NAME_USER_ACCEPT_RESCHEDULED);


        $subject = $star->profile_name . " has {$accepted} your new chat time";
        $body = $star->profile_name . " has {$accepted} your new chat time. ".($accept ? " Click here to " .
            "Video Chat now: ".$profile_link . "?vchat=1":'').
            "\n\n".
            "For questions, please contact support@collide.com\n".
            "\n".
            "Team Collide";

        $mail = [
            'email' => $user->email,
            'body' => $body,
            'subject' => $subject,
        ];

		CacheUtils::append('cron_mailer:1_1_vchat', $mail);
	}


    /**
     * Star accepts/declines scheduled video chat request from user
     *
     * @param $user
     * @param $star
     * @param $accept
     * @param $timestamp
     */
    public static function vchat_1_1_star_accept_scheduled($user, $star, $accept, $timestamp) {

        $accepted = $accept ? "accepted" : "declined";

        $time = date('H:i:sa M-d',strtotime($timestamp));

        // This should be set in `Star::full_url`, shouldn't it?
        $profile_link = WebUtils::dev_box() ? "https://qa.collide.com" . $star->url : $star->full_url;
        $message = $star->profile_name . " has {$accepted} your chat at {$time}.".($accept ? " Click here to " .
                "Video Chat now: ".$profile_link . "?vchat=1":'');

        self::notify($user->id, $message, self::NAME_STAR_ACCEPT_SCHEDULED);


        $subject = $star->profile_name . " has {$accepted} your chat at {$time}";
        $body = $star->profile_name . " has {$accepted} your chat at {$time}.".($accept ? " Click here to " .
            "Video Chat now: ".$profile_link . "?vchat=1":'').
            "\n\n".
            "For questions, please contact support@collide.com\n".
            "\n".
            "Team Collide";

        $mail = [
            'email' => $user->email,
            'body' => $body,
            'subject' => $subject,
        ];

        CacheUtils::append('cron_mailer:1_1_vchat', $mail);
    }


    /**
	 * Email and sms notification sent to a star when a user has requested a video chat.
	 *
	 * @return true if message sent, false if there was an error.
	 *
	 * @param $user   A user object
	 * @param $star   A star object
	 * @param $star_user  The user object for the star (to get star's contact information)
     * @return bool
	 */
	public static function vchat_1_1_requested($user, $star_user){
		
//       Log::debug("In vchat star requested with star: " . $star->profile_name);
        
        $user_display_name = $user->display_name;
        if (empty($user_display_name)) {
            $user_display_name = $user->username;
        }

        $message = message::text('vchat_request',
                ['user_display_name' => $user_display_name,
                 // Creator notification to Video Chat link must go to Collide
                 'site_url'=> 'https://www.collide.com/'], false);

        self::notify($star->user->id, $message, self::NAME_VCHAT_REQUESTED);

        $user_email = $star_user->email;

        $mail = message::email('vchat_request',
            ['user_display_name' => $user_display_name,
                // Creator notification to Video Chat link must go to Collide
                'site_url'=> 'https://www.collide.com/']
        );

        $mail['email'] = $user_email;
        
        CacheUtils::append('cron_mailer:1_1_vchat',$mail);
        
		return true;
		
	}

    /**
     * SMS notification to supporter when video chat request expires.
     * #4722
     *
     * @return true if message sent, false if there was an error.
     *
     * @param $user   A user object
     * @param $star   A star object
     * @return bool
     */

	public static function vchat_expired($user, $star, $site_id) {

		$user_number = user_mobile_num::get_valid_number($user->id);
		if (!$user_number) {
			return false;
		}

		// Some key/values are coming back incorrect in dev environments, possibly from direct edits to
		// the DB. Instead make direct query against DB value to guarantee latest mobile number entry
		if (WebUtils::dev_box()) {
			$user_number = user_mobile_num::where('user_id', $user->id)->first();
		}

		$profile_link = "https://" . (WebUtils::dev_box() ? 'qa.collide.com' : 'collide.com') . $star->url;

		$message = "Your video chat request with " . $star->profile_name . " has expired. "
		. "Go here to submit another request: " . $profile_link;

               $site_label = site::where('id', $site_id)->first()->display_name;
		self::notify($user->id, $message, self::NAME_VCHAT_EXPIRED, ['site_label' => $site_label]);

		return true;
	}


    /**
     * SMS / WebPush notification when Creator turns on video/sms/phone
     * connect services
     * #4656
     *
     * @return true if message sent, false if there was an error.
     *
     * @param {star} - $star - A star object
     * @param {string array} - $services array - Array of newly activated connect services
     * @return {bool} - true if notification sent successfully
     */

    public static function connect_service_activated($star, $services) {


        $user_notify_list = NotificationUtils::get_followers_subscribers($star->id);


        if(!count($user_notify_list)) {
            //Log::notice("No users following or subscribed to star " . $star->profile_name
            //    . " with star id: " . $star->id);
            return false;
        }

        // Send notification for each service activated
        foreach ($services as $service) {

            if (!strlen($service)) {
                continue;
            }

            // Construct appropriate message based on service activated
            $service_message = null;
            switch ($service) {
                case 'SMS':
                    $service_message = 'to text.';
                    $notification_name = self::NAME_SMS_AVAILABLE;
                    break;
                case 'PHONE':
                    $service_message = 'for voice calls.';
                    $notification_name = self::NAME_PHONE_AVAILABLE;
                    break;
                case '1_1_VIDEO_CHAT':
                    $service_message = 'to video chat.';
                    $notification_name = self::NAME_VCHAT_AVAILABLE;
                    break;
                default:
                    Log::notice("Invalid service name " . $service . " passed to NotificationUtils::notify() !");
                    return false;
            }
            $message = $star->profile_name . " is available " . $service_message;
            $site_link = "https://" . (WebUtils::dev_box() ? 'qa.collide.com' : 'collide.com');
            $message = $message . " View here: " . $site_link . $star->url . "#connect";


            // Begin processing notifications to all subscribed or following users
            foreach ($user_notify_list as $user_id) {

                self::notify($user_id, $message, $notification_name);
                //Log::debug("Message: " . $message . " successfully sent to supporter " . $user->display_name);
            }
        }
        //Log::debug("Completed service turn on notify");



    }



    /**
     * SMS / WebPush notification when Creator changes connect service
     * prices
     * #4861
     *
     * @param {int} - $star_id
     * @param {array} - $service_prices Array of services with updated pricing
     *
     * @throws {Exception} - Missing ID exception
     * @return {bool} - true if message sent, false if there was an error.
     */
    public static function connect_price_change($star_id, $service_prices) {

        $star = star::fetch(['id' => $star_id]);
        if (!$star) {
            Log::notice("No star found for star_id " . $star_id);
            return false;
        }

        // Get latest entry (current service prices) for star rates
        $service_prices_current = star_rate::where('star_id', $star_id)
            ->orderBy('id', 'DESC')
            ->first()
            ->toArray();

        if (!count($service_prices_current)) {
            //Log::debug("No previous rate records found, not sending");
            return;
        }

        $connect_services = [
            'send_sms' => false,
            'send_mms' => false,
            'voice_minute' => false,
            'vchat11' => false
        ];

        // Get diff on updated service prices
        foreach ($connect_services as $service => $val) {
            if ($service_prices[$service] != $service_prices_current[$service]) {

                //Log::debug("Price for service " . $service . " has changed");
                // Mark true if service price has changed
                $connect_services[$service] = true;
            }
        }

        // Format credits to dollar amount
        foreach ($service_prices as $service => $price ) {
            $service_prices[$service] = number_format($service_prices[$service]/100, 2) . " credit"
                . ($price >= 100 && $price < 200 ? "" : "s");

        }

        //Log::debug("About to notify for " . print_r($connect_services,true));

        // Get subscriber list id's to notify
        $user_notify_list = NotificationUtils::get_followers_subscribers($star_id, 'subscriber-only');

        //Log::debug("Got notify list with " . count($user_notify_list) . " entries");


        // Define messages to send supporter
        $site_link = "https://" . (WebUtils::dev_box() ? 'qa.collide.com' : 'collide.com');
        $sms_message = $star->profile_name. " changed their text pricing to " . $service_prices['send_sms']
            . " per message. View here: " . $site_link . $star->url . "#connect";
        $mms_message = $star->profile_name. " changed their pricing to " . $service_prices['send_mms']
            . " per media message. View here: " . $site_link . $star->url . "#connect";
        $voice_message = $star->profile_name . " changed their Voice Call pricing to " . $service_prices['voice_minute']
            . " per minute. View here: " . $site_link . $star->url . "#connect";
        $vchat_message = $star->profile_name . " changed their Video Chat pricing to " . $service_prices['vchat11']
            . " per minute. View here: " . $site_link . $star->url . "#connect";

        // Store in associative array for iterative message selection
        $service_messages = [
            'send_sms' => $sms_message,
            'send_mms' => $mms_message,
            'voice_minute' => $voice_message,
            'vchat11' => $vchat_message
        ];


        // Iterate through subscriber list
        foreach ($user_notify_list as $user_id) {

            $user = User::find($user_id);
            if (!$user) {
                Log::notice("No user found for ID " . $user_id);
                continue;
            }

            // Iterative through connect services
            foreach($connect_services as $connect_service => $requires_notify) {

                // Connect services with false entries for requires_notify can skip message send
                if (!$requires_notify) {
                    //Log::debug("skipping require notify for service " . $connect_service);
                    continue;
                }

                $notification_name = self::_connect_price_change_name($connect_service);
                // Get specific message for service
                $message = $service_messages[$connect_service];
                //Log::debug("Preparing to send message to user " . $user->display_name . " with message: "
                //    . $message);

                self::notify($user_id, $message, $notification_name);


            }
        }
    }

    private static function _connect_price_change_name($connect_service) {

        $connect_services = [
            'send_sms' => self::NAME_SMS_PRICE_CHANGE,
            'send_mms' => self::NAME_MMS_PRICE_CHANGE,
            'voice_minute' => self::NAME_VOICE_PRICE_CHANGE,
            'vchat11' => self::NAME_VCHAT_PRICE_CHANGE
        ];
        return $connect_services[$connect_service];
    }

    public static function new_follow_name($mode) {
        if ($mode == 'follow') {
            return self::NAME_NEW_FOLLOW_NOTIFY;
        }
        return self::NAME_NEW_UNFOLLOW_NOTIFY;
    }


	public static function subscription_purchase($star, $star_user, $sub_package, $user){
		
        //Log::debug("In new subscription purchase notify with star: " . $star->profile_name);
        $twilio = new twilio();
        $username = strlen(trim($user->display_name)) ? $user->display_name : $user->username;


        $text_msg = message::text('subscription_purchase',
            [
                'user_display_name' => $username,
                'sub_name' => $sub_package
            ]
        );
        self::notify($star_user->id, $text_msg, self::NAME_SUB_PURCHASE);

        $user_email = $star_user->email;

        $mail = message::email('subscription_purchase',
            [
                'user_display_name' => $username,
                'sub_name' => $sub_package
            ]
        );

        $mail['email'] = $user_email;
        
        CacheUtils::append('cron_mailer:sub_purchase',$mail);
        
		return true;
		
	}



	/**
     * SMS / WebPush notifcation when Creator deletes a subscription tier
     * #4663
     *
     * @param $star_subscription - A star_subscribe collection
     * @throws {Exception} - Missing ID Exception
     *
     * @return {bool} - true if message sent, false if there was an error.
     */

    public static function subscription_tier_deleted($star_subscription) {

        // Instantiate corresponding star to star_subscription
        $star = star::fetch(['id' => $star_subscription->star_id]);

        if (!$star) {
            Log::notice("Star not found with star ID: " . $star_subscription->star_id);
            return false;
        }

        // Get the subscription details from the subscribe table
        $subscription = subscribe::where('id', $star_subscription->subscribe_id)->first();


        // Get the lowest Premium sub assigned to that star ( starts at 32 )
        $lowest_premium_sub = star_subscribe::where('star_id', $star_subscription->star_id)
            ->where('subscribe_id', '>=', 32)
            ->orderBy('subscribe_id', 'ASC')
            ->first();


        if (!$lowest_premium_sub) {
            Log::notice("Can't find lowest premium subscription for star ID" . $star->id);
            return false;
        }

        // Get the subscription details for the lowest premium sub from the subscribe table
        $lowest_premium_sub = subscribe::where('id', $lowest_premium_sub->subscribe_id)->first();


        // Form message
        $site_link = "https://" . (WebUtils::dev_box() ? 'qa.collide.com/' : 'collide.com/');
        $message = "Content from " . $subscription->name . " has been reassigned to " .
            $lowest_premium_sub->name . ". You can reassign your content under 'Manage Content': " .
            $site_link . "manage-content";



        //Log::debug("getting ready to send message " . $message);
        self::notify($star->user->id, $message, self::NAME_SUB_TIER_DELETE);



        return true;


    }

    public static function get_followers_subscribers($star_id, $mode = false) {

        // Get unique list of all subscribers OR followers
        $subscriber_list = array_unique(user_subscribe::where('star_id', $star_id)
            ->where('status', 'ACTIVE')
            ->pluck('user_id')
            ->toArray());

        if ($mode == 'subscriber-only') {
            return $subscriber_list;
        }

        $follower_list = array_unique(user_notify_online::where('star_id', $star_id)
            ->pluck('user_id')
            ->toArray());

        if ($mode == 'follower-only') {
            return $follower_list;
        }

        return array_unique(array_merge($subscriber_list, $follower_list));

    }

    /**
     * For development environments, determines whether notification recipient
     * is in approved set of emails/numbers to avoid sending dev notifications
     * to live Creators
     *
     * For production environments, returns true to approve all recipients
     *
     * @param {string} $number - Recipient's Twilio number entry
     * @param {string} $email - Recipient's email
     * @return {bool}
     */
    public static function dev_box_notify($number, $email) {

        if (WebUtils::prod_db()) {
            return true;
        }
        if (stripos($email, '@collide.com')) {
            return true;
        }


        // Iterate through approved numbers with stripos() to account
        // for Twilio +1 additions
        try {
            foreach (WhiteLabel::config('dev_numbers') as $approved_number) {
                if (stripos($number, $approved_number)) {
                    return true;
                }
            }
        }
        catch (Exception $e) {
            Log::notice("Failed verifying numbers with exception " . $e);
            return false;
        }
        return false;
    }


    /**
     * Helper function to log notifications to the
     * user_message_log table.
     *
     *
     * @param {user object} $user - user table object
     * @param {string} $type - Type of notification (SMS/SNS/IN-APP/ETC)
     * @param {string} $name - Label for notification in user_message_log
     *
     * @return {bool} - True if successfully sent on all specified platforms
     */
    public static function log_notify($user, $type, $name) {



        //Log::debug("In function log_notify about to log notification " . $name);
        $message_log_record = [
            'user_id' => $user->id,
            'star_id' => $user->star_id,
            'type' => $type,
            'name' => $name
        ];

        //Log::debug(print_r($message_log_record,true));
        user_message_log::insert($message_log_record);

    }



    /**
     * Handles multi-platform notifications
     *
     * By default when called, notifications will be sent via SMS if mobile
     * number can be found, and via In-app notification by posting the notification
     * to the `message` table, owned by SYSTEM
     *
     * @param {integer} $recipient_id
     * @param {string} $message - Message to send
     * @param {string} $notification_name - Notification label for user_message_log
     * @param {string array} $platforms - List of platforms to send notification
     *
     * @return {bool} - True if successfully sent on all specified platforms
     */
    public static function notify($recipient_id, $message, $notification_name, $state = []) {

        //Log::debug("In function notify with user id " . $recipient_id . " for notification " . $notification_name);
        // Get user object from ID
        $recipient = User::find($recipient_id);
        if (!$recipient) {
            Log::notice("Could not find user with user_id " . $recipient_id);
            return false;
        }

        $email = $recipient->email;
        //Log::debug("Got user email as " . $email);


        $mobile_num = null;
        // Find Twilio number for star or user
        if ($recipient->star_id) {
            try {
                $star = star::fetch([
                    'id' => $recipient->star_id
                ]);
                $mobile_num = $star->number;
                //Log::debug("User is star, got number via star column: " . $mobile_num);
            }
            catch (Exception $e) {
                Log::notice("Could not fetch star with star_id" . $recipient->star_id
                    . " with exception " . $e);
                return false;
            }
        }
        else {
            if (user_mobile_num::get_valid_number($recipient_id)) {
                $mobile_num = user_mobile_num::get_valid_number($recipient_id)->number;
            }
            //Log::debug("User is not star, got number via user_mobile_num with number: " . $mobile_num);
        }


        // Vet notification recipients for dev environments
        if (!self::dev_box_notify($mobile_num, $email)) {

            //Log::debug("Failed dev box notify check for user id " . $recipient_id
             //   . " exiting now");
            return false;
        }

        $notify_all_platforms = !(in_array('skip_sms', $state) || in_array('skip_in_app', $state)
            || in_array('skip_web_push', $state));

        // Notify SMS
        if ($mobile_num && ($notify_all_platforms || !in_array('skip_sms', $state))) {

            $twilio = new twilio();

            //Log::debug("About to send message " . $message . "to user " . $recipient->username);
            if (!$twilio->send_message($mobile_num,
                message::system($message . WebUtils::dev_label($recipient->username)), $state) ) {
                Log::notice("Could not queue message for " . $mobile_num);
            }
            else {

                //Log::debug("Logging message in user_message_log");
                self::log_notify($recipient, 'SMS', $notification_name);
            }
        }


        // Notify In-app
        if (false) {
        //if ($notify_all_platforms || !in_array('skip_in_app', $state)) {

            notify_in_app::send_notification($recipient_id, $message, $notification_name, $state);
        }

        // Notify Web-Push
        if ($notify_all_platforms || !in_array('skip_web_push', $state)) {

            // Push user ID and message to redis and have cron process messages
            CacheUtils::append(user_subscribe_webpush::WEB_PUSH_CACHE_KEY, [
                "user_id" => $recipient_id,
                "payload" => $message,
                "notification_name" => $notification_name
            ]);

        }
        return true;
    }
    public static function unread_messages($user){
        $receiver = Auth::user();
        return chat::where([['view','=',0],['receiver_id','=',$receiver->id],['user_id','=',$user]])->count();

    }


}
