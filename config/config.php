<?php

return [
    'url' => env('UPTIME_PING_URL', null),
    'method' => env('UPTIME_PING_METHOD', 'GET'),
    'retries' => 3,
    'timeout' => 3, // seconds
    'headers' => [
        // 'User-Agent' => 'Laravel Uptime Ping',
    ],
];
