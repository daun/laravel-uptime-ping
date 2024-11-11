<?php

use Illuminate\Console\Scheduling\Schedule;

it('adds a new job to the queue', function () {
    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with(null)->andReturnSelf();
    $schedule->shouldReceive('everyMinute')->once()->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});

it('makes the job conditional on the url being defined', function () {
    config(['uptime-ping.url' => 'https://example.net']);

    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('https://example.net')->andReturnSelf();
    $schedule->shouldReceive('everyMinute')->once()->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});
