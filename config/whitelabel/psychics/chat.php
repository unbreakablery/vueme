<?php

$chatConfigs = [
    'production' => [
        'enabled' => false,
//        'jwt_secret' => 'chatstar_very_secretive_secret',
        'jwt_secret' => 'TJKv22Yas1pPRm7/OuQ/ffcPuNOgiTmE',
        'jwt_time' => 10000,
        'video_host' => 'enc1.collide.com',
        'video_edge' => 'edge1.collide.com',
//        'video_cdn' => 'videocdn.collide.com',
	    'video_cdn' => 'free.collide.com',
        'video_app' => 'cam',
        'video_cdn_app' => '',
        'ws_host' => 'chat.collide.com',
        'star_transaction_history' => true,
    ],
    'local' => [
        'enabled' => false,
        'jwt_secret' => 'TJKv22Yas1pPRm7/OuQ/ffcPuNOgiTmE',
        'jwt_time' => 10000,
        'video_host' => 'enc3-dev.collide.com',
        'video_edge' => 'edge1-dev.collide.com',
//        'video_edge' => 'edgefree1-dev.collide.com',
//      'video_cdn' => 'dbsoh580p6iax.cloudfront.net',
	    'video_cdn' => 'free-dev.collide.com',
// 	    'video_cdn' => 'edgefree-dev.collide.com',
// 	    'video_cdn' => 'edgefree1-dev.collide.com',
        'video_app' => 'cam',
        'video_cdn_app' => '',
        'ws_host' => 'dev-chat.collide.com',
        'star_transaction_history' => true,
    ],
    'development' => [
        'enabled' => false,
        'jwt_secret' => 'TJKv22Yas1pPRm7/OuQ/ffcPuNOgiTmE',
        'jwt_time' => 10000,
        'video_host' => 'enc3-dev.collide.com',
        'video_edge' => 'edge1-dev.collide.com',
//        'video_edge' => 'edgefree1-dev.collide.com',
//      'video_cdn' => 'dbsoh580p6iax.cloudfront.net',
	    'video_cdn' => 'free-dev.collide.com',
//	    'video_cdn' => 'edgefree-dev.collide.com',
// 	    'video_cdn' => 'edgefree1-dev.collide.com',
        'video_app' => 'cam',
        'video_cdn_app' => '',
        'ws_host' => 'dev-chat.collide.com',
        'star_transaction_history' => true,
    ],
    'staging' => [
        'enabled' => false,
        'jwt_secret' => 'TJKv22Yas1pPRm7/OuQ/ffcPuNOgiTmE',
        'jwt_time' => 10000,
        'video_host' => 'enc1-stage.collide.com',
        'video_edge' => 'edge1-dev.collide.com',
//         'video_cdn' => 'video-stage.collide.com',
	    'video_cdn' => 'free-dev.collide.com',
        'video_app' => 'cam',
        'video_cdn_app' => '',
        'ws_host' => 'chat-stage.collide.com',
        'star_transaction_history' => true,
    ]
];

return $chatConfigs;

?>
