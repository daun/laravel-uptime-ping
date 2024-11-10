<?php

namespace Daun\LaravelUptimePing;

use Daun\LaravelUptimePing\Jobs\UptimePing;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom($this->getConfigFile(), 'uptime-ping');
        if ($this->app->runningInConsole()) {
            $this->publishes([$this->getConfigFile() => config_path('uptime-ping.php')], 'uptime-ping-config');
        }
    }

    public function boot(Schedule $schedule)
    {
        $schedule->job(UptimePing::class)
            ->when(config('uptime-ping.url'))
            ->cron(config('uptime-ping.cron', '* * * * *'));
    }

    protected function getConfigFile(): string
    {
        return __DIR__ . '/../config/config.php';
    }
}
