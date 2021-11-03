<?php

declare(strict_types=1);

namespace Domain\Delivery\Actions;

use Integration\Swoove\ServiceZones\CheckZone;

class CheckInDeliveryZone
{
    public static function check(string $longitude, string $latitude): array
    {
        return CheckZone::build()->withData([
            'longitude' => $longitude,
            'latitude' => $latitude,
        ])
            ->send()
            ->json();
    }
}
