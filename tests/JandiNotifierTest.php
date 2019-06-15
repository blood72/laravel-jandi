<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\Notifications\JandiBasicNotification;
use Blood72\Jandi\Notifications\Messages\JandiMessage;
use Illuminate\Notifications\AnonymousNotifiable;
use Jandi;
use Illuminate\Support\Facades\Notification;
use ReflectionObject;

class JandiNotifierTest extends TestCase
{
    /**
     * Test whether recipients can be set by to() method with string parameter.
     *
     * @throws \ReflectionException
     */
    public function testSetRecipientsWithStringParam()
    {
        $jandi = Jandi::to('hello to() test');

        $recipients = $this->getPrivatePropertyValueFromObject('recipients', $jandi);

        $actual = [
            [Notification::route('jandi', 'hello to() test')],
        ];

        $this->assertEquals($actual, $recipients);
    }

    /**
     * Test whether recipients can be set by to() method with string parameters.
     *
     * @throws \ReflectionException
     */
    public function testSetRecipientsWithStringParams()
    {
        $jandi = Jandi::to('hello to() test 1', 'hello to() test 2');

        $recipients = $this->getPrivatePropertyValueFromObject('recipients', $jandi);

        $actual = [
            [Notification::route('jandi', 'hello to() test 1')],
            [Notification::route('jandi', 'hello to() test 2')],
        ];

        $this->assertEquals($actual, $recipients);
    }

    /**
     * Test whether recipients can be set by to() method with array parameter.
     *
     * @throws \ReflectionException
     */
    public function testSetRecipientsWithArrayParam()
    {
        $jandi = Jandi::to([
            'hello to() test 1',
            'hello' => 'to() test 2',
            'hello to()' => [
                'test 3', 'test 4'
            ]
        ]);

        $recipients = $this->getPrivatePropertyValueFromObject('recipients', $jandi);

        $actual = [
            [Notification::route('jandi', 'hello to() test 1')],
            'hello' => [Notification::route('jandi', 'to() test 2')],
            'hello to()' => [
                Notification::route('jandi', 'test 3'),
                Notification::route('jandi', 'test 4'),
            ],
        ];

        $this->assertEquals($actual, $recipients);
    }

    /**
     * Test whether recipients can be set by to() method with object parameter.
     *
     * @throws \ReflectionException
     */
    public function testSetRecipientsWithObjectParam()
    {
        $jandi = Jandi::to(collect([new TestModelOne, new TestModelTwo]));

        $recipients = $this->getPrivatePropertyValueFromObject('recipients', $jandi);

        $actual = [
            'hello' => [Notification::route('jandi', 'to() test 1')],
            1 => [Notification::route('jandi', 'hello to() test 2')],
        ];

        $this->assertEquals($actual, $recipients);
    }

    /**
     * Test whether the notifier can send a notification with instant message.
     *
     * @return void
     */
    public function testSendNotificationWithInstantMessageByNotifier(): void
    {
        $notification = Notification::fake();

        Jandi::to(['hello' => 'to() test'])->send('send() test');

        $notification->assertSentTo(new AnonymousNotifiable, JandiBasicNotification::class);
        $sentMessage = $notification->sent(new AnonymousNotifiable, JandiBasicNotification::class)->first()->toJandi();
        $this->assertEquals('hello', $sentMessage->email);
        $this->assertEquals('send() test', $sentMessage->content);
    }

    /**
     * Test whether the notifier can send a notification with defined message.
     *
     * @return void
     */
    public function testSendNotificationWithDefinedMessageByNotifier(): void
    {
        $notification = Notification::fake();

        $message = (new JandiMessage)->to('hello')->content('send() test');

        Jandi::send($message);

        $notification->assertSentTo(new AnonymousNotifiable, JandiBasicNotification::class);
        $sentMessage = $notification->sent(new AnonymousNotifiable, JandiBasicNotification::class)->first()->toJandi();
        $this->assertEquals('hello', $sentMessage->email);
        $this->assertEquals('send() test', $sentMessage->content);
    }

    /**
     * Get private property value from object.
     *
     * @param  string  $propertyName
     * @param  object  $object
     * @return mixed
     * @throws \ReflectionException
     */
    private function getPrivatePropertyValueFromObject(string $propertyName, $object)
    {
        $reflection = new ReflectionObject($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
