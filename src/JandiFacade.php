<?php

namespace Blood72\Jandi;

use Illuminate\Support\Facades\Facade;

class JandiFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return JandiNotifier::class;
    }
}
