<?php

namespace App\Domains\Delivery\Facade;

use App\Domains\Delivery\Contract\DeliveryResolvableContract;
use Illuminate\Support\Facades\Facade;

class Delivery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DeliveryResolvableContract::class;
    }
}
