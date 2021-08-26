<?php

namespace Domain\Cart\Facade;

use Domain\Cart\Contracts\CartContract;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CartContract::class;
    }
}
