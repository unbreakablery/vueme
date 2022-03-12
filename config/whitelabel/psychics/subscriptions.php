<?php

return [
	'subscription_policy' => 'MULTIPLE PER TYPE ALLOWED' // Many subscriptions of each type.
	//'subscription_policy' => 'ONE EACH' // ONE subscription of each type.
	,'type_names' => [
        'MEDIA'=>'Premium'
        ,'PATRON'=>'Support'
	]
    ,'default_values' => [
	'name' => 'Custom Subscription',
	'credits_price' => 299,
	'duration' => 1,
	'duration_period' => 'MONTH',
	'type' => 'MEDIA',
	'custom' => 'YES',
	'collect_email' => 'NO',
	'collect_shipping_address'=> 'NO',
	'social_media_names' => null
]
    ,'services' => [
	'instagram'=>'INSTAGRAM'
	,'youtube'=>'YOUTUBE'
	,'snapchat'=>'SNAPCHAT'
	, 'twitter'=>'TWITTER'
]
];
