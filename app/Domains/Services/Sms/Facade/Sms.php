<?php

namespace App\Domains\Services\Sms\Facade;

use App\Domains\Services\Sms\SmsContract;
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
