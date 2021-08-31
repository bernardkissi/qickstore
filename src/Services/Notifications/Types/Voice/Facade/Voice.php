<?php

namespace Service\Notifications\Types\Voice\Facade;

use Illuminate\Support\Facades\Facade;
use Service\Notifications\Types\Voice\VoiceContract;

class Voice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return VoiceContract::class;
    }
}
