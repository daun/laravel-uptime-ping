<?php

namespace Daun\LaravelUptimePing\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class UptimePing implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $url = config('uptime-ping.url');
        if (! $url) {
            return;
        }

        $method = config('uptime-ping.method', 'GET');
        $retries = (int) config('uptime-ping.retries', 3);
        $timeout = (int) config('uptime-ping.timeout', 5);
        $headers = (array) config('uptime-ping.headers', []);

        Http::retry($retries)
            ->timeout($timeout)
            ->withHeaders($headers)
            ->send($method, $url);
    }
}
