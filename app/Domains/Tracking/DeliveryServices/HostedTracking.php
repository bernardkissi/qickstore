<?php

namespace App\Domains\Tracking\DeliveryServices;

use App\Domains\Tracking\Contract\TrackableContract;

class HostedTracking implements TrackableContract
{
    public function track(): string
    {
        return 'hello hosted tracking you';
    }
}
