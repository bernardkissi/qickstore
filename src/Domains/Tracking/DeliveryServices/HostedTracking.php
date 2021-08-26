<?php

namespace Domain\Tracking\DeliveryServices;

use Domain\Tracking\Contract\TrackableContract;

class HostedTracking implements TrackableContract
{
    public function track(): string
    {
        return 'hello hosted tracking you';
    }
}
