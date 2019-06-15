<?php

namespace Blood72\Jandi\Test;

use Blood72\Jandi\Notifications\Channels\JandiWebhookChannel;
use GuzzleHttp\Client as HttpClient;
use Mockery;

class JandiChannelTest extends TestCase
{
    /** @var \GuzzleHttp\Client|\Mockery\MockInterface */
    protected $http;

    /** @var \Blood72\Jandi\Notifications\Channels\JandiWebhookChannel */
    protected $channel;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->http = Mockery::mock(HttpClient::class);

        $this->channel = new JandiWebhookChannel($this->http);
    }

    /**
     * Test whether the channel can send a notification with Channel.
     *
     * @return void
     */
    public function testSendNotificationWithChannel(): void
    {
        $this->http->shouldReceive('post');

        $this->channel->send(new TestNotifiable, new TestJandiNotification);
    }
}
