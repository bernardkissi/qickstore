<?php

namespace App\Helpers\Transitions;

use Illuminate\Support\Facades\Facade;

class MapState extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TransitionMapper::class;
    }
}
