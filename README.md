# 📡  Laravel Uptime Ping

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

If you need to change the request method, adjust the timeout and number of retries, or add custom
headers, publish and adjust the config file by running
`php artisan vendor:publish --tag=laravel-uptime-ping`.

```php
return [
    'url' => env('UPTIME_PING_URL', null),
    'method' => env('UPTIME_PING_METHOD', 'GET'),
    'retries' => 3,
    'timeout' => 3,
    'headers' => [],
];
```

## License

[MIT](https://opensource.org/licenses/MIT)
