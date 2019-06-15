<?php

namespace Blood72\Jandi\Notifications\Messages;

use Closure;

class JandiMessage
{
    /**
     * The email to send the message from.
     *
     * @var string|null
     */
    public $email;

    /**
     * The text content of the message.
     *
     * @var string
     */
    public $content;

    /**
     * The attachment section's color (6 hex code).
     *
     * @var string
     */
    public $color;

    /**
     * The message's attachments.
     *
     * @var JandiAttachment[]
     */
    public $attachments = [];

    /**
     * Additional request options for the Guzzle HTTP client.
     *
     * @var array
     */
    public $http = [
        'headers' => [
            'Accept' => 'application/vnd.tosslab.jandi-v2+json',
            'Content-Type' => 'application/json',
        ],
    ];

    /**
     * Jandi Message constructor.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Create a new Jandi message.
     *
     * @param  string $content
     * @return static
     */
    public static function create($content = ''): self
    {
        return new static($content);
    }

    /**
     * Set a email for the Jandi team message.
     *
     * @param  string  $email
     *
     * @return $this
     */
    public function to($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the color of the attachment section.
     *
     * @param  string  $color
     *
     * @return $this
     */
    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Set a primary color of Bootstrap 4
     *
     * @return $this
     */
    public function primary(): self
    {
        return $this->color('#007bff');
    }

    /**
     * Set a secondary color of Bootstrap 4
     *
     * @return $this
     */
    public function secondary(): self
    {
        return $this->color('#6c757d');
    }

    /**
     * Set a success color of Bootstrap 4
     *
     * @return $this
     */
    public function success(): self
    {
        return $this->color('#28a745');
    }

    /**
     * Set a danger color of Bootstrap 4
     *
     * @return $this
     */
    public function danger(): self
    {
        return $this->color('#dc3545');
    }

    /**
     * Set a warning color of Bootstrap 4
     *
     * @return $this
     */
    public function warning(): self
    {
        return $this->color('#ffc107');
    }

    /**
     * Set a info color of Bootstrap 4
     *
     * @return $this
     */
    public function info(): self
    {
        return $this->color('#17a2b8');
    }

    /**
     * Set a light color of Bootstrap 4
     *
     * @return $this
     */
    public function light(): self
    {
        return $this->color('#f8f9fa');
    }

    /**
     * Set a dark color of Bootstrap 4
     *
     * @return $this
     */
    public function dark(): self
    {
        return $this->color('#343a40');
    }

    /**
     * Set the content of the Jandi message.
     *
     * @param  string  $content
     *
     * @return $this
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Define an attachment for the message.
     *
     * @param  \Closure  $callback
     *
     * @return $this
     */
    public function attachment(Closure $callback): self
    {
        $this->attachments[] = $attachment = new JandiAttachment;

        $callback($attachment);

        return $this;
    }

    /**
     * Set additional request options for the Guzzle HTTP client.
     *
     * @param  array $http
     *
     * @return $this
     */
    public function http(array $http): self
    {
        $this->http = $http;

        return $this;
    }
}
