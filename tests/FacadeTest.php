<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\JandiFacade;
use Blood72\Jandi\JandiNotifier;

class FacadeTest extends TestCase
{
    /**
     * Check whether the Facade can be called up.
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testResolve(): void
    {
        $this->assertTrue(class_exists('Jandi'));

        $actual = JandiFacade::getFacadeRoot();

        $this->assertInstanceOf(JandiNotifier::class, $actual);
    }
}
