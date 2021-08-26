<?php

namespace Domain\Services\Notifications\Types\Voice\Facade;

use App\Domains\Services\Notifications\Types\Voice\VoiceContract;
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
