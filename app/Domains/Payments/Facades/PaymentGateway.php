<?php

namespace App\Domains\Payments\Facades;

use App\Domains\Payments\Contract\PaymentableContract;
use Illuminate\Support\Facades\Facade;

class PaymentGateway extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PaymentableContract::class;
    }
}
