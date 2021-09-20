<?php

namespace Domain\Orders\Checkouts\Facade;

use Domain\Orders\Checkouts\Contract\Checkoutable;
use Illuminate\Support\Facades\Facade;

class Checkout extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Checkoutable::class;
    }
}
