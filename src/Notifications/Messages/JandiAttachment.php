<?php

namespace Blood72\Jandi\Notifications\Messages;

class JandiAttachment
{
    /**
     * The attachment's title (markdown).
     *
     * @var string
     */
    public $title;

    /**
     * The attachment's description (markdown).
     *
     * @var string
     */
    public $description;

    /**
     * The attachment's bottom image (url).
     *
     * @var string
     */
    public $image;

    /**
     * Set the title of the attachment.
     *
     * @param  string  $title
     *
     * @return $this
     */
    public function title($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the description of the attachment.
     *
     * @param  string  $description
     *
     * @return $this
     */
    public function description($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the image URL.
     *
     * @param  string  $url
     *
     * @return $this
     */
    public function image($url): self
    {
        $this->image = $url;

        return $this;
    }
}
