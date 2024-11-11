<?php

namespace Tests;

use Daun\LaravelUptimePing\ServiceProvider;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Orchestra\Testbench\Concerns\CreatesApplication;

abstract class TestCase extends LaravelTestCase
{
    use CreatesApplication;

    protected $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createServiceProvider();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function createServiceProvider()
    {
        $this->provider = new ServiceProvider($this->app);
    }

    protected function bootServiceProvider()
    {
        if (! $this->provider) {
            $this->createServiceProvider();
        }
        $this->app->call([$this->provider, 'register']);
        $this->app->call([$this->provider, 'boot']);
    }
}
