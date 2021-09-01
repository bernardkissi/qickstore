<?php

namespace Domain\Payments\Facade;

use Domain\Payments\Contract\PaymentableContract;
use Illuminate\Support\Facades\Facade;

class Payment extends Facade
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
