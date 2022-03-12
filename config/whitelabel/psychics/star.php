<?php

return [
    'support_email' => 'partnersupport@collide.com',
    'request_email' => 'partnerrequest@collide.com',
    'alias' => 'creator',
    'alias_pl' => 'creators',
    'alias_full_lower' => 'content_creator',
    'alias_full' => 'Content Creator',
    'alias_full_pl' => 'Content Creators',
    'enable_live_stream' => false,
    'search_returns_videos' => true, // Set this to false for broadcast_cnt to be the live broadcast count in search
                                     // results.
    'must_be_subscribed_for_network_but_network_free'=>true, //The user must be subscribed for a network, but it is
    // free.
    'default_subscriptions' => [

//	    "$2.99 Media",
//	    "$.99 Donation"
    ],
    
    // Set this to false if no email go out, otherwise is email address
    'self_onboarding_notify_mailing_list' => [
        'brian+nc@collide.com',
        'georgina+nc@collide.com',
        'kelsey+nc@collide.com',
        'ken+nc@collide.com',
        'molly+nc@collide.com',
        'siobhan+nc@collide.com',
        'tim+nc@collide.com',
        'jenna+nc@collide.com',
        'kelvin+nc@collide.com'
    ],
    'whitelisted_emails' => [
        '@collide.com'
    ],
    'self_onboarding_activates' => true,
    'onboarding_flags' => [
        'UPLOADED_PROFILE_PICTURE',
        'ABOUT_ME',
        'PHONE_NUMBER',
        'UPLOADED_INTRO_VIDEO',
        'UPLOADED_PUBLIC_POST',
        'UPLOADED_PREMIUM_POST',
        'ACTIVATE_CONNECT',
        'BANK_INFORMATION_COLLECTED',
        'COMPLETED' // only when all other flags are set.
    ],
    'subscription_types'=>[
    	'MESSAGE'
	    ,'MEDIA'
	    ,'PATRON'
    ],
    'chat_filter_all_ages'=>[
    	0,
	    2
    ],
    'chat_filter_mature'=>[
	    1,
    ],

    'chat_filter_explicit'=>[
	    3,
	    4
    ],

    'referral_base'=>"/creator/onboard/signup"
    ,'referral_prefix'=>"referral-r"
    ,'referral_letter'=>"r"
    ,'referral_periods_start_date'=>"2018-01-01"
    ,'referral_periods_days' => 30
];
