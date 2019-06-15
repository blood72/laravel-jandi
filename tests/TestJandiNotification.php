<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\Notifications\JandiNotification;
use Blood72\Jandi\Notifications\Messages\JandiMessage;

class TestJandiNotification extends JandiNotification
{
    /**
     * {@inheritDoc}
     */
    public function toJandi($notifiable = null): JandiMessage
    {
        return new JandiMessage;
    }
}
