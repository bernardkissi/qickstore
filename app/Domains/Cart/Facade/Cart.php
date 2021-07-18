<?php

namespace App\Domains\Cart\Facade;

use App\Domains\Cart\Contracts\CartContract;
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
