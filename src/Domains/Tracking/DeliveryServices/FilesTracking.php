<?php

namespace Domain\Tracking\DeliveryServices;

use Domain\Tracking\Contract\TrackableContract;

class FilesTracking implements TrackableContract
{
    public function track(): string
    {
        return 'hello files tracking you';
    }
}
