<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public/uploads'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'media' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->media['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->media['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->media['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->media['bucket'],
        ],

        'assets' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->assets['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->assets['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->assets['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->assets['bucket'],
        ],

        'media_purchase' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->media_purchase['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->media_purchase['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->media_purchase['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->media_purchase['bucket'],
        ],
        'text_chat' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->text_chat['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->text_chat['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->text_chat['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->text_chat['bucket'],
        ],


        'media_message' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->media_message['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->media_message['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->media_message['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->media_message['bucket'],
        ],

        'vod_media_prod' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->vod_media_prod['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->vod_media_prod['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->vod_media_prod['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->vod_media_prod['bucket'],
        ],

        'vod_media_stage' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->vod_media_stage['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->vod_media_stage['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->vod_media_stage['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->vod_media_stage['bucket'],
        ],

        'vod_media_dev' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->vod_media_dev['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->vod_media_dev['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->vod_media_dev['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->vod_media_dev['bucket'],
        ],

        'logs' => [
            'driver' => 's3',
            'key'    => \App\Services\WhiteLabel::config('media')->logs['key'],
            'secret' => \App\Services\WhiteLabel::config('media')->logs['secret'],
            'region' => \App\Services\WhiteLabel::config('media')->logs['region'],
            'bucket' => \App\Services\WhiteLabel::config('media')->logs['bucket'],
        ],
        'files' => [
            'driver' => 'local',
            'root' => public_path('files'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

    ],

];
