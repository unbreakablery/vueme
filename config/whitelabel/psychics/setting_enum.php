<?php

return [
    'post_type'=>            ['TEXT', 'VIDEO', 'IMAGE'],

    'status_type'=>          ['PUBLISHED', 'DRAFT'],

    'pricing'=>         [ 'Teaser', 'Premium'],

    'text_format' =>         ['PLAIN','MARKDOWN'],



    'media_status'=>         ['QUEUED','PROCESSING','PROCESSED','REJECTED','ACTIVE'],

    'media_type' =>          ['IMAGE','VIDEO'],

    'media_sale_types' =>    ['BUY','DONATE'],

    'ext_allowed'     =>     [    'image' =>     ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
                                  'video' =>     ['mp4', 'wmv', 'mpeg', 'mpg', 'mov', 'avi', 'flv', 'f4v'],
                                  'audio' => ['wav', 'aiff', 'aif', 'aifc', 'flac', 'm4a', 'caf', 'mp3', 'aac', 'wma', 'ogg'],
                                /* 'pdf' => ['pdf'],
                                 'compressed' => ['zip', 'rar', 'gz', 'tgz', '7z', 'sit', 'sitx']*/ ],


];