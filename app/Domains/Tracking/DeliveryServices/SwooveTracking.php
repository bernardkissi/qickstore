<?php

namespace App\Domains\Tracking\DeliveryServices;

use App\Domains\Tracking\Contract\TrackableContract;

class SwooveTracking implements TrackableContract
{
    public function track(): string
    {
        return 'hello swoove tracking you';
    }
}
