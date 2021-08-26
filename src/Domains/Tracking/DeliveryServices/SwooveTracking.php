<?php

namespace Domain\Tracking\DeliveryServices;

use Domain\Tracking\Contract\TrackableContract;

class SwooveTracking implements TrackableContract
{
    public function track(): string
    {
        return 'hello swoove tracking you';
    }
}
