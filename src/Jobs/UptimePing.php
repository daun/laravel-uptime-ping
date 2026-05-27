<?php

namespace Daun\LaravelUptimePing\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class UptimePing implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    /**
     * Don't retry failed pings at the queue level
     */
    public int $tries = 1;

    /**
     * Hard ceiling on worker time spent on the job
     */
    public int $timeout = 30;

    /**
     * Prevent new pings while a previous one is still processing
     */
    public function uniqueFor(): int
    {
        return 60;
    }

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
