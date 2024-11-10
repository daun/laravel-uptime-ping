<?php

return [

    // The URL to ping
    'url' => env('UPTIME_PING_URL', null),

    // The HTTP method to use
    'method' => env('UPTIME_PING_METHOD', 'GET'),

    // The frequency at which to ping the URL, in crontab syntax (see https://crontab.guru)
    'cron' => env('UPTIME_PING_CRON', '* * * * *'),

    // The number of retries before failing
    'retries' => 3,

    // The timeout in seconds before failing
    'timeout' => 3,

    // Additional headers to send with the request
    'headers' => [
        // 'User-Agent' => 'Laravel Uptime Ping',
    ],

];
