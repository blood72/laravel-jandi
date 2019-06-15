<?php

namespace Blood72\Jandi\Test;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

class NotificationTest extends TestCase
{
    /**
     * Test whether the channel can send a notification with Notification facade.
     *
     * @return void
     */
    public function testSendNotificationWithNotificationFacade(): void
    {
        $notification = Notification::fake();

        $notifiable = new TestNotifiable;

        $notification->send($notifiable, new TestJandiNotification);

        $notification->assertSentTo($notifiable, TestJandiNotification::class);
    }

    /**
     * Test whether the channel can send a notification with AnonymousNotifiable.
     *
     * @return void
     */
    public function testSendNotificationWithAnonymousNotifiable(): void
    {
        $notification = Notification::fake();
        $notifiable = (new AnonymousNotifiable)->route('jandi', 'hello AnonymousNotifiable test');

        $notification->send($notifiable, new TestJandiNotification);

        $notification->assertSentTo(
            new AnonymousNotifiable,
            TestJandiNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['jandi'] == 'hello AnonymousNotifiable test';
            }
        );
    }
}
