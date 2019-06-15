<?php

namespace Blood72\Jandi;

use Blood72\Jandi\Notifications\JandiBasicNotification;
use Blood72\Jandi\Notifications\Messages\JandiMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class JandiNotifier
{
    /**
     * The recipients array. It includes the recipient's email (optional) and webbook URL.
     *
     * @var array
     */
    private $recipients = [];

    /** @var array */
    private $config;

    /**
     * Create a new Jandi notifier.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->to($this->config['jandi_webhook_url']);
    }

    /**
     * Set the recipients and webhook URL to send notifications.
     *
     * @param  object|array|string $recipients
     *
     * @return $this
     */
    public function to($recipients): self
    {
        $this->recipients = [];

        if ($recipients instanceof Collection) {
            $recipients = $recipients->all();
        }

        $recipients = is_array($recipients) ? $recipients : func_get_args();

        foreach ($recipients as $email => $value) {
            if (is_object($value) and $model = $value) {
                $this->addJandiRecipient(
                    $model->jandi_email ?? $email,
                    $this->getRecipientUrlFromObject($model)
                );

                continue;
            }

            foreach ((array) $value as $url) {
                $this->addJandiRecipient($email, $url);
            }
        }

        return $this;
    }

    /**
     * Send a new message.
     *
     * @param string|\Blood72\Jandi\Notifications\Messages\JandiMessage  $message
     * @param string $notification
     */
    public function send($message, $notification = JandiBasicNotification::class)
    {
        $jandiMessage = $this->setJandiMessage($message);

        foreach ($this->recipients as $email => $urls) {
            foreach ($urls as $anonymousNotifiable) {
                if (is_string($email)) {
                    $jandiMessage = (clone $jandiMessage)->to($email);
                }

                /** @var \Illuminate\Notifications\AnonymousNotifiable $anonymousNotifiable */
                $anonymousNotifiable->notify(new $notification($jandiMessage));
            }
        }
    }

    /**
     * Add JANDI notification recipient.
     *
     * @param  int|string $email
     * @param  string|null $url
     *
     * @return void
     */
    protected function addJandiRecipient($email, $url): void
    {
        if (empty($url)) {
            return;
        }

        $this->recipients[$email][] = Notification::route('jandi', $url);
    }

    /**
     * Get the recipient URL from object.
     *
     * @param  object  $model
     *
     * @return string
     */
    protected function getRecipientUrlFromObject($model): string
    {
        if (method_exists($model, 'routeNotificationForJandi')) {
            return $model->routeNotificationForJandi();
        }

        return $model->jandi_webhook_url;
    }

    /**
     * Check JANDI message data type and return object
     *
     * @param  string|JandiMessage  $message
     *
     * @return JandiMessage
     */
    protected function setJandiMessage($message): JandiMessage
    {
        if (! $message instanceof JandiMessage) {
            $message = (new JandiMessage)->content($message);
        }

        return $message;
    }
}
