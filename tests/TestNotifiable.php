<?php

namespace Blood72\Jandi\Test;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    /**
     * Get the value of the model's primary key.
     *
     * @return string
     */
    public function getKey()
    {
        return 'hello test key';
    }

    /**
     * Get the notification routing information for the jandi driver.
     *
     * @return string
     */
    public function routeNotificationForJandi()
    {
        return 'hello routeNotificationForJandi() test';
    }
}
