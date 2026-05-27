<?php

use Illuminate\Console\Scheduling\Schedule;

it('adds a new job to the queue', function () {
    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with(null)->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('* * * * *')->andReturnSelf();
    $schedule->shouldReceive('cron')->once()->with('* * * * *')->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});

it('makes the job conditional on the url being defined', function () {
    config(['uptime-ping.url' => 'https://example.net']);

    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('https://example.net')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('* * * * *')->andReturnSelf();
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
    $schedule->shouldReceive('when')->once()->with('*/5 * * * *')->andReturnSelf();
    $schedule->shouldReceive('cron')->once()->with('*/5 * * * *')->andReturnSelf();

    $this->app->instance(Schedule::class, $schedule);

    $this->bootServiceProvider();
});

it('dispatches the job when url and cron are both configured', function () {
    config(['uptime-ping.url' => 'https://example.net']);
    config(['uptime-ping.cron' => '* * * * *']);

    $this->bootServiceProvider();

    $event = collect($this->app->make(Schedule::class)->events())->first();

    expect($event)->not->toBeNull();
    expect($event->filtersPass($this->app))->toBeTrue();
});

it('does not dispatch the job when url is empty', function () {
    config(['uptime-ping.url' => '']);
    config(['uptime-ping.cron' => '* * * * *']);

    $this->bootServiceProvider();

    $event = collect($this->app->make(Schedule::class)->events())->first();

    expect($event)->not->toBeNull();
    expect($event->filtersPass($this->app))->toBeFalse();
});

it('does not dispatch the job when cron expression is empty', function () {
    config(['uptime-ping.url' => 'https://example.net']);
    config(['uptime-ping.cron' => '']);

    $this->bootServiceProvider();

    $event = collect($this->app->make(Schedule::class)->events())->first();

    expect($event)->not->toBeNull();
    expect($event->filtersPass($this->app))->toBeFalse();
});
