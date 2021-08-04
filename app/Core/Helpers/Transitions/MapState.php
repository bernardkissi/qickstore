<?php

namespace App\Core\Helpers\Transitions;

use App\Core\Helpers\Transitions\TransitionMapper;
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
