<?php

declare(strict_types=1);

namespace Domain\Delivery\Services;

use Integration\Swoove\ServiceZones\GetServiceZones;

class SwooveServiceZones
{
    public static function getZones(): array
    {
        return GetServiceZones::build()->withData([])->send()->json();
    }
}
