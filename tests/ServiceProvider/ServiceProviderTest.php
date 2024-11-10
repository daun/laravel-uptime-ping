<?php

use Illuminate\Console\Scheduling\Schedule;

it('adds a new job to the queue', function () {
    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('job')->once()->with('Daun\LaravelUptimePing\Jobs\UptimePing')->andReturnSelf();
    $schedule->shouldReceive('when')->once()->with('https://example.net')->andReturnSelf();
    $schedule->shouldReceive('everyMinute')->once()->andReturnSelf();

    $this->bootServiceProvider();
});
