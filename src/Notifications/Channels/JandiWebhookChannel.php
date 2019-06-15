<?php

namespace Blood72\Jandi\Notifications\Channels;

use Blood72\Jandi\Notifications\Messages\JandiMessage;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\Notification;

class JandiWebhookChannel
{
    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Create a new Jandi channel instance.
     *
     * @param  \GuzzleHttp\Client  $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification|  $notification
     *
     * @return \Psr\Http\Message\ResponseInterface|void|null
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var \Illuminate\Notifications\Notifiable  $notifiable */
        if (! $url = $notifiable->routeNotificationFor('jandi', $notification)) {
            return;
        }

        return $this->http->post($url, $this->buildJsonPayload(
            /** @var \Blood72\Jandi\Notifications\JandiNotification  $notification */
            $notification->toJandi($notifiable)
        ));
    }

    /**
     * Build up a JSON payload for the Jandi webhook.
     *
     * @param  \Blood72\Jandi\Notifications\Messages\JandiMessage  $message
     *
     * @return array
     */
    protected function buildJsonPayload(JandiMessage $message)
    {
        $optionalFields = array_filter([
            'email' => data_get($message, 'email'),
            'connectColor' => data_get($message, 'color'),
            'connectInfo' => $this->getAttachmentsData($message),
        ]);

        return array_merge([
            'json' => array_merge([
                'body' => $message->content,
            ], $optionalFields),
        ], $message->http);
    }

    /**
     * Format the message's attachments.
     *
     * @param  \Blood72\Jandi\Notifications\Messages\JandiMessage  $message
     *
     * @return array
     */
    protected function getAttachmentsData(JandiMessage $message)
    {
        return collect($message->attachments)->map(function ($attachment) {
            return array_filter([
                'title' => $attachment->title,
                'description' => $attachment->description,
                'imageUrl' => $attachment->image,
            ]);
        })->all();
    }
}
