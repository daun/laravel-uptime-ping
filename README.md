# 📡  Laravel Uptime Ping

[![Latest Version on Packagist](https://img.shields.io/packagist/v/daun/laravel-uptime-ping.svg)](https://packagist.org/packages/daun/laravel-uptime-ping)
[![Test Status](https://img.shields.io/github/actions/workflow/status/daun/laravel-uptime-ping/ci.yml?label=tests)](https://github.com/daun/laravel-uptime-ping/actions/workflows/ci.yml)
[![Code Coverage](https://img.shields.io/codecov/c/github/daun/laravel-uptime-ping)](https://app.codecov.io/gh/daun/laravel-uptime-ping)
[![License](https://img.shields.io/github/license/daun/laravel-uptime-ping.svg)](https://github.com/daun/laravel-uptime-ping/blob/master/LICENSE)

A **dead man's switch** for Laravel apps that **regularly pings an endpoint** to confirm the site is
up and its task scheduler is processing important jobs, such as backups and notifications. A missed
ping indicates issues with the job queue.

Useful with health monitors like [Uptime Kuma](https://uptime.kuma.pet/).

## Installation

Install the package via composer:

```bash
composer require daun/laravel-uptime-ping
```

## How it works

An **uptime ping sent from within the job queue** is the most reliable method for detecting a broken
job queue. While your site may be running, a misconfigured cron job might prevent your backups and
notifications from being processed. A standard health check wouldn't necessarily identify this issue.

The package will send a GET request to your configured endpoint every minute. This way, you'll know
immediately if the site goes down or the job queue stops processing items.

## Basic setup

Define the URL to ping in your `.env` file. For more customization, see below.

```bash
UPTIME_PING_URL="https://uptime.kuma.instance/api/push/xxxxxxxxxx?status=up&msg=OK&ping="
```

## Configuration

To change the frequency of pings, request method, timeout, number of retries, or add custom headers,
publish and adjust the config file by running `php artisan vendor:publish --tag=uptime-ping-config`.
Adjust any settings in `config/uptime-ping.php`.

```php
return [

    /*
    | The URL to ping. If this is not set, the job will not run.
    */

    'url' => env('UPTIME_PING_URL', null),

    /*
    | The frequency at which to ping the URL, in crontab syntax. @see https://crontab.guru for help
    */

    'cron' => env('UPTIME_PING_CRON', '* * * * *'),

    /*
    | The HTTP method to use when pinging the URL.
    */

    'method' => env('UPTIME_PING_METHOD', 'GET'),

    /*
    | The number of retries to attempt before failing.
    */

    'retries' => 3,

    /*
    | The timeout in seconds before failing.
    */

    'timeout' => 3,

    /*
    | Additional headers to send with the request.
    */

    'headers' => [
        // 'User-Agent' => 'Laravel Uptime Ping',
    ],

];

```

## License

[MIT](https://opensource.org/licenses/MIT)
