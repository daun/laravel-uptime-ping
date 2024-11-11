<?php

use Illuminate\Console\Scheduling\Schedule;

it('adds a new job to the queue', function () {
    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with(null)->andReturnSelf();
    $schedule->shouldReceive('cron')->once()->with('* * * * *')->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});

it('makes the job conditional on the url being defined', function () {
    config(['uptime-ping.url' => 'https://example.net']);

    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('https://example.net')->andReturnSelf();
    $schedule->shouldReceive('cron')->once()->with('* * * * *')->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});

it('passes the frequency into the schedule', function () {
    config(['uptime-ping.url' => 'https://example.net']);
    config(['uptime-ping.cron' => '*/5 * * * *']);

    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('https://example.net')->andReturnSelf();
    $schedule->shouldReceive('cron')->once()->with('*/5 * * * *')->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});
