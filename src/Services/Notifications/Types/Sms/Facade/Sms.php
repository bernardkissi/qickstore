<?php

namespace Service\Notifications\Types\Sms\Facade;

use Illuminate\Support\Facades\Facade;
use Service\Notifications\Types\Sms\SmsContract;

class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SmsContract::class;
    }
}
