<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\Notifications\Messages\JandiAttachment;

class JandiAttachmentTest extends TestCase
{
    /**
     * Test whether the attachment title can set by title().
     *
     * @return void
     */
    public function testTitle(): void
    {
        $attachment = new JandiAttachment;

        $attachment->title('hello title() test');

        $this->assertEquals('hello title() test', $attachment->title);
    }

    /**
     * Test whether the attachment description can set by description().
     *
     * @return void
     */
    public function testDescription(): void
    {
        $attachment = new JandiAttachment;

        $attachment->description('hello description() test');

        $this->assertEquals('hello description() test', $attachment->description);
    }

    /**
     * Test whether the attachment image URL can set by image().
     *
     * @return void
     */
    public function testImage(): void
    {
        $attachment = new JandiAttachment;

        $attachment->image('hello image() test');

        $this->assertEquals('hello image() test', $attachment->image);
    }
}
