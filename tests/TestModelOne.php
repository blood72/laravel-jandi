<?php

namespace Blood72\Jandi\Test;

use Illuminate\Database\Eloquent\Model;

class TestModelOne extends Model
{
    /**
     * Get the model's JANDI email.
     *
     * @return string
     */
    public function getJandiEmailAttribute()
    {
        return 'hello';
    }

    /**
     * Get the model's JANDI webhook url.
     *
     * @return string
     */
    public function getJandiWebhookUrlAttribute()
    {
        return 'to() test 1';
    }
}
