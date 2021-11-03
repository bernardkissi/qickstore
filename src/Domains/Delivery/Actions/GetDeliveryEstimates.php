<?php

declare(strict_types=1);

namespace Domain\Delivery\Actions;

use Integration\Swoove\Delivery\GetEstimates;
use Integration\Swoove\Delivery\SwooveDto;

class GetDeliveryEstimates
{
    public static function estimate(array $orderData): array
    {
        $estimate = GetEstimates::build()
            ->withData(SwooveDto::estimateTransferObject($orderData))
            ->send()
            ->json();

        return $estimate['responses']['estimates'];
    }
}
