<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\JandiFacade;
use Blood72\Jandi\JandiServiceProvider;
use Mockery;
use Orchestra\Testbench\TestCase as BaseClass;

class TestCase extends BaseClass
{
    /**
     * Register the service.
     *
     * @param \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [JandiServiceProvider::class];
    }

    /**
     * Register the alias.
     *
     * @param \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return ['Jandi' => JandiFacade::class];
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();

        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }

    /**
     * Get the base configuration.
     *
     * @return array
     */
    protected function getBaseConfig()
    {
        return $this->app['config']['laravel-jandi'];
    }
}
