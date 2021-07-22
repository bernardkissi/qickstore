<?php

namespace App\Domains\Services\Notifications\Types\Sms\Facade;

use App\Domains\Services\Notifications\Types\Sms\SmsContract;
use Illuminate\Support\Facades\Facade;

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