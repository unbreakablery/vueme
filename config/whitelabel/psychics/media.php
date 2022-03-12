<?php
$env = env('APP_ENV_BUCKET') == 'prod' ? '' : '-dev';
return [
    'media' => [
        'url' => 'http://sexy1on1-dev-media.s3.us-west-2.amazonaws.com',
        'url_cdn' => 'https://premium-media.sexy1on1.com',
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'sexy1on1-dev-media',
        'dimension' => [
            //V1
            'PROFILE_V1' => [
                'active' => true,
                'size' => ['1000+', '1000+', 1],
                'thumb_version' => 1,
                'additional' => [
                    0 => [
                        [500, 500],
                        [1000, 1000],
                    ],
                    1 => [
                        [250, 250],
                        [500, 500],
                        [1000, 1000],
                    ],
                ],
            ],

            //V0
            'PROFILE_INDEX' => [
                'active' => false,
                'size' => [338, 225],
                'thumb_version' => 0,
            ],
            'PROFILE' => [
                'active' => false,
                'size' => [300, 380],
                'thumb_version' => 0,
            ],
            'PROFILE_BG' => [
                'active' => true,
                'size' => [1149, 316],
                'thumb_version' => 0,
            ],
        ],
    ],
    'text_chat' =>
    [
        'url' => 'https://vueme-media-chat.s3.amazonaws.com',        
        'key' => env('AWS_ACCESS_KEY_ID', ''),
        'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
        'region' => 'us-east-1',
        'bucket' => 'vueme-media-chat'.$env,
    ],
    'media_purchase' => [
        'url' => 'http://sexy1on1-dev-media.s3.us-west-2.amazonaws.com',
       /* 'url_cdn' => 'https://premium-media.collide.com',*/
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'sexy1on1-dev-media',


        /*'cdn_private_key' => '',
        'cdn_key_pair_id' => '',*/
        /*'dimension' => [
            'V1' => [
                'active' => true,
                'size' => ['1000+', '1000+', 1],
                'additional' => [
                    [500, 500],
                    [1000, 1000],
                ],
            ],
            'V0' => [
                'active' => false,
                'size' => [320, 320],
            ],
        ],*/
    ],
    'media_message' => [
        'url' => 'https://vueme-assets.s3.amazonaws.com',
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'collide-message-media',
        'dimension' => [
            'V1' => [
                'active' => true,
                'min_size' => 500,
            ],
            'V0' => [
                'active' => false,
                'size' => [320, 320],
            ],
        ],
    ],
    'assets' => [
        'url' => 'https://vueme-assets.s3.amazonaws.com',
        'key' => env('AWS_ACCESS_KEY_ID', ''),
        'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
        'region' => 'us-east-1',
        'bucket' => 'vueme-assets'.$env
    ],
    'vod_media_prod' => [
        'url' => 'https://collide-vod-media.s3.amazonaws.com',
        'url_cdn' => 'https://vod.collide.com',
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'collide-vod-media',
        'cdn_private_key' => '',
        'cdn_key_pair_id' => '',
    ],
    'vod_media_stage' => [
        'url' => 'https://collide-vod-media-stage.s3.amazonaws.com',
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'collide-vod-media-stage',
    ],
    'vod_media_dev' => [
        'url' => 'https://collide-vod-media-dev.s3.amazonaws.com',
        'url_cdn' => 'https://vod-dev.collide.com',
        'key' => '',
        'secret' => '',
        'region' => 'us-west-2',
        'bucket' => 'collide-vod-media-dev',
        'cdn_private_key' => '',
        'cdn_key_pair_id' => '',
    ],
    // Maybe don't use the same hard-coded key for ALL buckets?
    'logs' => [
        'url' => 'https://collide-logs.s3.amazonaws.com',
        'url_cdn' => 'https://logs.collide.com',
        'key' => '',
        'secret' => '',
        'region' => 'us-west-1',
        'bucket' => 'collide-logs',
        'cdn_private_key' => '',
        'cdn_key_pair_id' => '',
    ],
	'media_departments' => [
		'LIBRARY'
		,'BULLETINS'
	]
];
