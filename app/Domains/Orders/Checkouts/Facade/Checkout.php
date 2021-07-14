<?php

namespace App\Domains\Orders\Checkouts\Facade;

use App\Domains\Orders\Checkouts\Contract\CheckoutableContract;
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
        return CheckoutableContract::class;
    }
}
