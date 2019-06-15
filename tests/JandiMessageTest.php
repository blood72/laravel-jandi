<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\Notifications\Messages\JandiAttachment;
use Blood72\Jandi\Notifications\Messages\JandiMessage;

class JandiMessageTest extends TestCase
{
    /**
     * Test whether the message content can be defined by __construct().
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $message = new JandiMessage('hello __construct() test');

        $this->assertEquals('hello __construct() test', $message->content);
    }

    /**
     * Test whether the message content can be defined by create().
     *
     * @return void
     */
    public function testCreate(): void
    {
        $message = JandiMessage::create('hello create() test');

        $this->assertEquals('hello create() test', $message->content);
    }

    /**
     * Test whether the message content can set by content().
     *
     * @return void
     */
    public function testContent(): void
    {
        $message = new JandiMessage;

        $message->content('hello content() test');

        $this->assertEquals('hello content() test', $message->content);
    }

    /**
     * Test whether the message email can set by to().
     *
     * @return void
     */
    public function testEmail(): void
    {
        $message = new JandiMessage;

        $message->to('hello to() test');

        $this->assertEquals('hello to() test', $message->email);
    }

    /**
     * Test whether the message color can set by color().
     *
     * @return void
     */
    public function testColor(): void
    {
        $message = new JandiMessage;

        $message->color('#727272');

        $this->assertEquals('#727272', $message->color);
    }

    /**
     * Test whether the message attachment can be created by attachment().
     *
     * @return void
     */
    public function testAttachment(): void
    {
        $message = new JandiMessage;

        $message->attachment(function ($attachment) {
            /** @var \Blood72\Jandi\Notifications\Messages\JandiAttachment  $attachment */
            $attachment->title('hello attachment() test');
            $attachment->description('hello attachment() test');
        });

        $this->assertInstanceOf(JandiAttachment::class, $message->attachments[0]);
    }
}
