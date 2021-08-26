<?php

namespace Domain\Delivery\Dispatchers;

use Illuminate\Support\Facades\Facade;

class Dispatcher extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Dispatcher';
    }
}
