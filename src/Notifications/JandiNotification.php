<?php

namespace Blood72\Jandi\Notifications;

use Blood72\Jandi\Notifications\Messages\JandiMessage;
use Illuminate\Notifications\Notification as BaseClass;

abstract class JandiNotification extends BaseClass
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['jandi'];
    }

    /**
     * Get the Jandi representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Blood72\Jandi\Notifications\Messages\JandiMessage
     */
    abstract public function toJandi($notifiable): JandiMessage;
}
