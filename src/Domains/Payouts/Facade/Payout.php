<?php

namespace Domain\Payouts\Facade;

use App\Domains\Payouts\Contract\PayableContract;
use Illuminate\Support\Facades\Facade;

class Payout extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PayableContract::class;
    }
}
