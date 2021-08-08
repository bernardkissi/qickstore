<?php

namespace App\Domains\Delivery\Facade;

use App\Domains\Delivery\Contract\DeliverableContract;
use Illuminate\Support\Facades\Facade;

class Dispatch extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DeliverableContract::class;
    }
}
