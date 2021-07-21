<?php

namespace App\Domains\Services\Voice\Facade;

use App\Domains\Services\Voice\VoiceContract;
use Illuminate\Support\Facades\Facade;

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
