# 📡  Laravel Uptime Ping

A [dead man's switch](https://en.wikipedia.org/wiki/Dead_man%27s_switch) for
[Laravel](https://laravel.com/docs/11.x/queues) apps.
Automatically pings an endpoint to communicate that the site is up.

Useful with health monitors like [Uptime Kuma](https://uptime.kuma.pet/).

## Installation

Install the package via composer:

```bash
composer require daun/laravel-uptime-ping
```

## Basic setup

Define the URL to ping in your `.env` file, and the package will now send a GET request to that
URL every minute. For more customization, see below.

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
