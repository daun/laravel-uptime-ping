<?php

use Daun\LaravelUptimePing\Jobs\UptimePing;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake();
});

it('does not send request if url is not configured', function () {
    Config::set('uptime-ping.url', null);

    (new UptimePing)->handle();

    Http::assertNothingSent();
});

it('sends request if url is configured', function () {
    Config::set('uptime-ping.url', 'https://example.net');

    (new UptimePing)->handle();

    Http::assertSentCount(1);
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.net' &&
               $request->method() === 'GET';
    });
});

it('sends request with configured method', function () {
    Config::set('uptime-ping.url', 'https://example.net');
    Config::set('uptime-ping.method', 'POST');

    (new UptimePing)->handle();

    Http::assertSentCount(1);
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.net' &&
               $request->method() === 'POST';
    });
});

it('sends request with configured headers', function () {
    Config::set('uptime-ping.url', 'https://example.net');
    Config::set('uptime-ping.headers', ['X-Test' => 'Header']);

    (new UptimePing)->handle();

    Http::assertSentCount(1);
    Http::assertSent(function ($request) {
        return $request->url() === 'https://example.net' &&
               $request->header('X-Test') === ['Header'];
    });
});

// it('sends request with configured timeout', function () {
//     Config::set('uptime-ping.url', 'https://example.net');
//     Config::set('uptime-ping.timeout', 10);

//     (new UptimePing())->handle();

//     Http::assertSentCount(1);
//     Http::assertSent(function ($request) {
//         return $request->url() === 'https://example.net' &&
//                $request->timeout() === 10;
//     });
// });

// it('will retry request with configured number of retries', function () {
//     Config::set('uptime-ping.url', 'https://example.net');
//     Config::set('uptime-ping.retries', 3);

//     (new UptimePing())->handle();

//     Http::assertSentCount(1);
//     Http::assertSent(function ($request) {
//         return $request->url() === 'https://example.net' &&
//                $request->retries() === 3;
//     });
// });
