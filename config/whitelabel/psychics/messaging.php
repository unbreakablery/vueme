<?php

return [
    'text' => [
        'network_expired_star'                => 'The network with this fan has expired.  They need to re-purchase your phone number.  Hit them up with #FREE to get the conversation going again.',
        'network_expired_user'                => 'It doesn\'t appear you currently have a connection with :star_profile_name.  Please go to :star_full_url to create one.',
        'duplicate_message'                   => 'We have detected two duplicate messages in a row, for your benefit we have blocked the second message. No credits were deducted from your account.',
        'service_disabled_star'               => 'Your account settings do not currently offer :message_type services.  Please update your settings on the :site_name website to enable this feature.',
        'service_disabled_user'               => 'Sorry, :star_profile_name does not offer :message_type messages at this time.',
        'service_unavailable_star'            => 'Your account settings are currently marked unavailable for :message_type services.  Please update your settings on the :site_name website to make yourself available.',
        'service_unavailable_user'            => 'We apologize but :star_profile_name isn\'t available at the moment.  No credits were deducted from your account.  Please check back soon.',
        'consecutive_limit_star'              => 'There is a 3 sent messages in a row limit, please wait for the user to respond.  Your message was not sent.  Please include #FREE in your message to send the user a freebie.',
        'not_enough_credits_star'             => 'The user doesn\'t have enough credits to receive your message at this time.  Your message was not delivered.  Send them a free sms/mms to get a paid conversation going again by putting #FREE anywhere in the message.',
        'not_enough_credits_sms_tried_user_1' => ':star_profile_name tried to send you a message, but you do not have enough credits to receive it.',
        'not_enough_credits_sms_tried_user_2' => 'Please add more credits to see their response. <b><a href="#" onclick="$(\'#confirm-purchase-modal\').modal(\'show\')">Buy Credits</a></b>',
        'not_enough_credits_mms_tried_user_1' => ':star_profile_name tried to send you a media, but you do not have enough credits to receive it.',
        'not_enough_credits_mms_tried_user_2' => 'Please add more credits to see their response. <b><a href="#" onclick="$(\'#confirm-purchase-modal\').modal(\'show\')">Buy Credits</a></b>',
        'not_enough_credits_user' => 'Looks like you don\'t have enough credits to send your message. Please add more credits and try again. ' .
            '<b><a href="#" onclick="$(\'#confirm-purchase-modal\').modal(\'show\')">Buy Credits</a></b>',
        'send_failed_star'                    => 'Your message could not be delivered due to a connection error. Please try again in a few minutes.',
        'send_failed'                         => 'Sorry, this message was unable to be delivered.  No credits were deducted from your account',
        'failed_media'                        => 'Sorry, there was an error processing the media in your message.  No credits were deducted from your account',
        'failed_generic'                      => 'Sorry, this action is unable to be completed.',
        'filtered_user'                       => 'Sorry, your message contains inappropriate language and could not be sent. No credits have been charged.',
        'not_subscribed_star'                 => 'Your message could not be delivered. The supporter you are trying to reach is no longer subscribed.',
        'not_subscribed_star_free'            => 'The user must be a subscriber to receive your #FREE message.  Your message was not delivered.',
        'not_subscribed_sms_tried_user_1'     => ':star_profile_name tried to send you a message, but you are not a premium subscriber.',
        'not_subscribed_sms_tried_user_2'     => 'If you would like to resubscribe, go to :star_full_url',
        'not_subscribed_mms_tried_user_1'     => ':star_profile_name tried to send you media, but you are not a premium subscriber.',
        'not_subscribed_mms_tried_user_2'     => 'If you would like to resubscribe, go to :star_full_url',
        'not_subscribed_user'                 => 'Looks like you aren\'t subscribed to :star_profile_name, please login to resubscribe. Your message was not sent.',
        'vchat_request'                       => ':user_display_name wants to Video Chat! Click here and accept chat requests :site_urlapp/vchat Unanswered requests expire after two hours.',
        'subscription_purchase'               => ':user_display_name has just purchased a :sub_name subscription.',
        'no_phone_number'                     => 'Valid phone number needed to use this feature. Please go to your <a href="/my-profile" target="_blank">settings</a> to update.',
        'mms_error_user'                      => 'Media messages (MMS) cannot be sent to creators outside the US. Credits were not deducted from your account.',
        'mms_error_star'                      => 'Media messages (MMS) cannot be sent to supporters outside the US. You did not receive credit for this exchange.',
        'new_network_user'                    => 'You are now connected with :star_profile_name. Send a message to get the conversation started.',
        'new_network_star'                    => 'Supporter :user_display_name wants to message you. Respond now to get the conversation started.',
        'new_network_star_sms'                => 'Supporter :user_display_name wants to message you. Respond now to get the conversation started. :site_urlmessages',
],
    'email' => [
        'subscription_purchase' => [
            'subject' => 'New Subscription Purchase from :user_display_name',
            'body' => ":user_display_name has signed up for a :sub_name subscription!"
                    . "\n"
                    . "For questions, please contact support@collide.com\n"
                    . "\n",
        ],
        'vchat_request' => [
            'subject' => 'New Video Chat Request from :user_display_name',
            'body' => ":user_display_name wants to Video Chat! Click here to view and accept Video Chat requests: :site_urlapp?vchat=1\n"
                    . "\n"
                    . "For questions, please contact support@collide.com\n"
                    . "\n"
                    . "Unanswered requests expire after two hours.\n",
        ],
        'welcome' => [
            'subject' => 'Welcome to Collide!',
            'body' => "Thank you for becoming a Collide Creator. We can’t wait to see what you come up with! Now that your account is active, you can upload content and let your creative flag fly.\n"
                    . "\n"
                    . "\n"
                    . "Let’s get it started:\n"
                    . "\n"
                    . "Profile Picture & About Section - Show us how you shine! Tell your Supporters who you are and what your Collide channel is all about under your About section. Give Supporters a reason to champion your passion, so be sure to give them all the deets.\n"
                    . "\n"
                    . "Introduce Yourself - Create an intro video to give Supporters a taste of your channel. Remember, it’s all about promoting yourself!\n"
                    . "\n"
                    . "Set Your Rates, Choose how much Premium content, Subscription and Connect (calls, texts and/or media messages) will cost on your Collide channel.\n"
                    . "\n"
                    . "\n"
                    . "Pro tip: Let your fans know when you’re posting by sharing your personalized URL to all your social channels and promoting your Collide content through Instagram posts and stories, tweets, memes, and anywhere else you can think of. There’s no wrong way to do it! You can find your personalized link on your Creator Dashboard. Just click it and it’ll automatically copy.\n"
                    . "\n"
                    . "\n"
                    . "Got questions or want to meet up for Happy Hour? We got you. Just hit us up at support@collide.com!\n"
                    . "\n"
                    . "\n"
                    . "-Team Collide",
        ],
        'welcome_internal' => [
            'subject' => ':star_profile_name has joined collide as a :star_alias',
            'body' => ':star_profile_name has joined collide as a :star_alias'
            ."\n\n"
            .'Link: :site_url:star_full_url',
        ],
    ],
];
