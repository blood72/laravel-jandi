<?php

namespace Blood72\Jandi\Notifications;

use Blood72\Jandi\Notifications\Messages\JandiMessage;

class JandiBasicNotification extends JandiNotification
{
    /** @var  \Blood72\Jandi\Notifications\Messages\JandiMessage */
    protected $message;

    /**
     * Create a new Jandi notification.
     *
     * @param JandiMessage|null $message
     */
    public function __construct(JandiMessage $message = null)
    {
        if (! $message) {
            $message = new JandiMessage;
        }

        $this->message = $message;
    }

    /**
     * {@inheritDoc}
     */
    public function toJandi($notifiable = null): JandiMessage
    {
        return $this->message;
    }
}
