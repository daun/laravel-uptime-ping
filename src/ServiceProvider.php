<?php

namespace Daun\LaravelUptimePing;

use Daun\LaravelUptimePing\Jobs\UptimePing;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'uptime-ping');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config/config.php' => config_path('uptime-ping.php')], 'uptime-ping-config');
        }
    }

    public function boot(Schedule $schedule)
    {
        $schedule->job(UptimePing::class)
            ->when(config('uptime-ping.url'))
            ->everyMinute();
    }
}
