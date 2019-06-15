<?php

namespace Blood72\Jandi\Test;

use Illuminate\Database\Eloquent\Model;

class TestModelTwo extends Model
{
    /**
     * Get the model's JANDI webhook url.
     *
     * @return string
     */
    public function getJandiWebhookUrlAttribute()
    {
        return 'hello to() test 2';
    }
}
