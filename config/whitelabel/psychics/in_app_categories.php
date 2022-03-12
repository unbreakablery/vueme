<?php
    use App\Services\NotificationUtils;
    use App\Models\NotifyInApp;

    return [
        NotifyInApp::CATEGORY_CONNECT => [
            NotificationUtils::NAME_VCHAT_EXPIRED,
            NotificationUtils::NAME_SMS_AVAILABLE,
            NotificationUtils::NAME_PHONE_AVAILABLE,
            NotificationUtils::NAME_VCHAT_AVAILABLE,
            NotificationUtils::NAME_SMS_PRICE_CHANGE,
            NotificationUtils::NAME_MMS_PRICE_CHANGE,
            NotificationUtils::NAME_VOICE_PRICE_CHANGE,
            NotificationUtils::NAME_VCHAT_PRICE_CHANGE,
            NotificationUtils::NAME_STAR_JOINED,
            NotificationUtils::NAME_STAR_RESCHEDULED,
            NotificationUtils::NAME_USER_ACCEPT_RESCHEDULED,
            NotificationUtils::NAME_STAR_ACCEPT_SCHEDULED,
            NotificationUtils::NAME_VCHAT_REQUESTED
        ]
    ];

