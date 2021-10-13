<?php

declare(strict_types=1);

namespace Domain\Delivery\Actions;

use Domain\Delivery\Dtos\DeliveryDto;
use Integration\Swoove\Delivery\GetEstimates;
use Integration\Swoove\Delivery\SwooveDto;

use const Cerbero\Dto\CAMEL_CASE_ARRAY;

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
