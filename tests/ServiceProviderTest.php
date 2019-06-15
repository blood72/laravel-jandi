<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\JandiNotifier;
use Blood72\Jandi\JandiServiceProvider;

class ServiceProviderTest extends TestCase
{
    /**
     * Check that the service provider is providing correctly
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testIsNotDeferred(): void
    {
        /** @var \PHPUnit\Framework\MockObject\MockBuilder|\Illuminate\Support\ServiceProvider  $provider */
        $provider = $this->getMockBuilder(JandiServiceProvider::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['isDeferred'])
            ->getMock();

        $actual = $provider->isDeferred();

        $this->assertFalse($actual);
    }

    /**
     * Check that the service provider is providing correctly
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testRegister(): void
    {
        $actual = $this->app->get('jandi');

        $this->assertInstanceOf(JandiNotifier::class, $actual);
    }

    /**
     * Check that the service provider is providing correctly
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testProvides(): void
    {
        /** @var \PHPUnit\Framework\MockObject\MockBuilder|\Illuminate\Support\ServiceProvider  $provider */
        $provider = $this->getMockBuilder(JandiServiceProvider::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['provides'])
            ->getMock();

        $actual = $provider->provides();

        $this->assertContains(JandiNotifier::class, $actual);
    }
}
