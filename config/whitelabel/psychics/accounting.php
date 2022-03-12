<?php

return [
   
      'percent_to_charge' => 20,
      'percent_to_payout' => 80,
      'minimum_payout' => 75,
      'minimum_international_payout' => 150,


      //Not using
     // Surcharge for XXX
     'explicit_content_fee_percent'=>5,
    
      // Surcharge for foreign bank account
      'foreign_bank_fee_percent'=>2,



    'min_vendor_id'=> "20000",
    'max_vendor_id'=> "79999",
    'vendor_id_length' => 5,
    'credit_to_dollar' => .01,
    'credit_to_dollar_history' => [
	    [
		    'credit_to_dollar'=> .1
		    ,'begin_date' => '2016-01-04 00:00:00'
	    ]
	    ,[
	    'credit_to_dollar'=> .01
	    ,'begin_date' => '2018-02-27 00:00:00'
    ]
],
    'current_credit_to_dollar_start'=> '2018-02-27 00:00:00',
    'epoch_datetime' => '2016-01-04 00:00:00',
    'pay_scale_active' => ['80_20', '70_30', '87.5_12.5'],
    'default_pay_scale' => '87.5_12.5',
    'first_day_of_week' => 'monday',
    'action_payout' => [
	    '80_20' => [
		    'SMS_RECEIVE' => .8,
		    'SMS_SEND' => .8,
		    'MMS_SEND' => .8,
		    'MMS_RECEIVE' => .8,
		    'VOICE_START' => .8,
		    'VOICE_RECEIVE' => .8,
		    'VIDEO_CHAT_SESSION' => .8,
		    'VIDEO_CHAT_MINUTE' => 0, //DO NOT MAKE >0
		    'CREATE_NETWORK' => .8,
		    'ADMIN_CREDIT_STAR' => 1,
		    'MEDIA_PURCHASE' => .8,
		    'MEDIA_PURCHASE_BUY' => .8,
		    'MEDIA_PURCHASE_DONATE' => .9,
		    'RECORDED_STREAM' => .8,
		    'SUBSCRIPTION_CREATE' => .9,
		    'SUBSCRIPTION_RECUR' => .9,
		    'DONATE' => .9,
		    'TIP' => .9,
		    'GIFT' => .9,
		    'BULLETIN_PURCHASE' => .8,
		    'VCHAT_1_1_MINUTES' => .8
	    ],
	    '70_30' => [
		    'SMS_RECEIVE' => .8,
		    'SMS_SEND' => .8,
		    'MMS_SEND' => .8,
		    'MMS_RECEIVE' => .8,
		    'VOICE_START' => .8,
		    'VOICE_RECEIVE' => .8,
		    'VIDEO_CHAT_SESSION' => .8,
		    'VIDEO_CHAT_MINUTE' => 0, //DO NOT MAKE >0
		    'CREATE_NETWORK' => .8,
		    'ADMIN_CREDIT_STAR' => 1,
		    'MEDIA_PURCHASE' => .8,
		    'MEDIA_PURCHASE_BUY' => .8,
		    'MEDIA_PURCHASE_DONATE' => .8,
		    'RECORDED_STREAM' => .8,
		    'SUBSCRIPTION_CREATE' => .9,
		    'SUBSCRIPTION_RECUR' => .9,
		    'DONATE' => .9,
		    'TIP' => .9,
		    'GIFT' => .9,
		    'BULLETIN_PURCHASE' => .8,
		    'VCHAT_1_1_MINUTES' => .8
	    ],
	    '87.5_12.5' => [
		    'SMS_RECEIVE' => .8,
		    'SMS_SEND' => .8,
		    'MMS_SEND' => .8,
		    'MMS_RECEIVE' => .8,
		    'VOICE_START' => .8,
		    'VOICE_RECEIVE' => .8,
		    'VIDEO_CHAT_SESSION' => .8,
		    'VIDEO_CHAT_MINUTE' => 0, //DO NOT MAKE >0
		    'CREATE_NETWORK' => .8,
		    'ADMIN_CREDIT_STAR' => 1,
		    'MEDIA_PURCHASE' => .8,
		    'MEDIA_PURCHASE_BUY' => .8,
		    'MEDIA_PURCHASE_DONATE' => .8,
		    'RECORDED_STREAM' => .8,
		    'SUBSCRIPTION_CREATE' => .9,
		    'SUBSCRIPTION_RECUR' => .9,
		    'DONATE' => .9,
		    'TIP' => .9,
		    'GIFT' => .9,
		    'BULLETIN_PURCHASE' => .8,
		    'VCHAT_1_1_MINUTES' => .8
	    ],
    ],
    'action_payout_active' => [
        'SMS_RECEIVE',
        'SMS_SEND',
        'MMS_SEND',
        'MMS_RECEIVE',
        'VOICE_START',
        'VOICE_RECEIVE',
        'CREATE_NETWORK',
        'VIDEO_CHAT_SESSION',
        //'VIDEO_CHAT_MINUTE', DO NOT ENABLE
        'MEDIA_PURCHASE',
        'MEDIA_PURCHASE_BUY',
        'MEDIA_PURCHASE_DONATE',
        'RECORDED_STREAM',
        'SUBSCRIPTION_CREATE',
        'SUBSCRIPTION_RECUR',
        'TIP',
        'GIFT',
        'DONATE',
	    'BULLETIN_PURCHASE',
        'VCHAT_1_1_MINUTES',
    ],
    'action_payout_purchase' => [
	    'MEDIA_PURCHASE',
	    'MEDIA_PURCHASE_BUY',
	    'MEDIA_PURCHASE_DONATE',
	    'BULLETIN_PURCHASE',
    ],
    'action_payout_twilio' => [
	    'SMS_RECEIVE',
	    'SMS_SEND',
	    'MMS_SEND',
	    'MMS_RECEIVE',
	    'VOICE_START',
	    'VOICE_RECEIVE',
	    'CREATE_NETWORK',
    ],
    'action_payout_connect' => [
	    'SMS_RECEIVE',
	    'SMS_SEND',
	    'MMS_SEND',
	    'MMS_RECEIVE',
	    'VOICE_START',
	    'VOICE_RECEIVE',
	    'VCHAT_1_1_MINUTES'
    ],
    'action_payout_sms' => [
	    'SMS_RECEIVE',
	    'SMS_SEND',
    ],
    'action_payout_mms' => [
	    'MMS_SEND',
	    'MMS_RECEIVE',
    ],
    'action_payout_voice' => [
	    'VOICE_START',
	    'VOICE_RECEIVE',
    ],
    'action_payout_vchat' => [
	    'VCHAT_1_1_MINUTES'
    ],
    'action_payout_admin' => [
        'ADMIN_CREDIT_STAR',
    ],
    'action_payout_charity' => [
        'DONATE',
        'MEDIA_PURCHASE_DONATE',
    ],
    'action_payout_subscription' => [
        'SUBSCRIPTION_CREATE',
        'SUBSCRIPTION_RECUR',
    ],
    'gift_events' => [
    	'GIFT'
    	,'TIP'
    ],
    'live_stream_events' => [
    	'VIDEO_CHAT_SESSION'
    	,'VIDEO_CHAT_MINUTE'
    ],
    'subscription_events' => [
    	'SUBSCRIPTION_CREATE'
    	,'SUBSCRIPTION_RECUR'
    ],
	'library_events' => [
		'MEDIA_PURCHASE_BUY'
		,'MEDIA_PURCHASE'
	],
	'bulletin_events' => [
		'BULLETIN_PURCHASE'
	],
	'transaction_history' => [
        'SMS_RECEIVE',
        'SMS_SEND',
        'MMS_SEND',
        'MMS_RECEIVE',
        'VOICE_START',
        'VOICE_RECEIVE',
        'BILLING_ADD_CREDIT',
  //      'RESPONSE_REFUND_SMS_RECEIVE',
  //      'RESPONSE_REFUND_MMS_RECEIVE',
        'CREATE_NETWORK',
        'FREE_MMS_SEND',
        'FREE_SMS_SEND',
        'ADMIN_ADD_CREDIT',
        'VIDEO_CHAT_SESSION',
        'REFUND_VIDEO_CHAT_SESSION',
        //'VIDEO_CHAT_MINUTE', DO NOT ENABLE
        'MEDIA_PURCHASE',
        'MEDIA_PURCHASE_BUY',
        'MEDIA_PURCHASE_DONATE',
        'SUBSCRIPTION_CREATE',
        'SUBSCRIPTION_RECUR',
        'DONATE',
        'TIP',
        'USER_OFFER_SIGNUP_1',
        'GIFT',
	    'BULLETIN_PURCHASE',
        'VCHAT_1_1_MINUTES'
    ],
    'comp_credits'=>[
    	'ADMIN_ADD_CREDIT'
	    ,'REFUND_VIDEO_CHAT_SESSION'
	    ,'RESPONSE_REFUND_SMS_RECEIVE'
        ,'RESPONSE_REFUND_MMS_RECEIVE'
    ],
    'twilio_refund_actions'=>[
	    'RESPONSE_REFUND_SMS_RECEIVE'
	    ,'RESPONSE_REFUND_MMS_RECEIVE'
        ],
    //based on star_rate columns
    'dollar_rate_default' => [
        'create_network' => 1,
        'receive_sms' => 1.50,
        'send_sms' => 1.50,
        'receive_mms' => 2,
        'send_mms' => 2,
        'voice_minute' => 3,
        'ppm_stream' => 1,
        'ppv_stream' => 1,
        'media_purchase' => 1,
        'recorded_stream' => 1,
	    'bulletin' => .5,
        'vchat11' => 5,
    ],
    //based on star_rate columns
    'dollar_rate_min' => [
        'create_network' => 0,
        'receive_sms' => 1,
        'send_sms' => 1,
        'receive_mms' => 1,
        'send_mms' => 1,
        'voice_minute' => 1,
        'ppm_stream' => 0,
        'ppv_stream' => 0,
        'media_purchase' => 0,
        'recorded_stream' => .5,
	    'bulletin' => .1,
        'vchat11' => 1,
    ],
    //based on star_rate columns
    'dollar_rate_max' => [
        'create_network' => 10000,
        'receive_sms' => 10000,
        'send_sms' => 10000,
        'receive_mms' => 10000,
        'send_mms' => 10000,
        'voice_minute' => 10000,
        'ppm_stream' => 10000,
        'ppv_stream' => 10000,
        'media_purchase' => 10000,
        'recorded_stream' => 10000,
	    'bulletin' => 10000,
        'vchat11' => 10000
    ],
    'voice_minute_min' => 5,
    'vchat_1_1_minimum_duration' => 5,
    'accounting_email' => 'accounting@collide.com',
    'payout_type' => [
        'ACH',
        'CHECK',
        'WIRE',
        'PAYPAL',
    ],
    'refundable' => [
        'VIDEO_CHAT_SESSION',
    ],
    'accounting_bucket' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'collide-accounting',
    ],
    
   
    
    // Support for adverts
    // Set 'pre_defined_advert_id_only' to true to disallow ad-hoc advert ids
    'pre_defined_advert_id_only' => true,
    // Base date for MX adverts
    'mx_promotion_base_date' => '2019-03-08',
];
