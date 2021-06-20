<?php

namespace App\Domains\Tracking\DeliveryServices;

use App\Domains\Tracking\Contract\TrackableContract;

class FilesTracking implements TrackableContract
{
    public function track(): string
    {
        return 'hello files tracking you';
    }
}
