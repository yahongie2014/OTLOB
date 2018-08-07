<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAYxMtu7s:APA91bGpiW2SkGbc5zxsztDWjAEjKU512kReDKN4nc4iIBIGC-vy5uc7yS-9HyApk_ChP6IJGa4niL0cA1mKEeDAPDCIsmA7quzNpmEbRn-W6NFq6wqFl7AeJsTHube6GCdM7IpZfqrK'),
        'sender_id' => env('FCM_SENDER_ID', '425523526587'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
