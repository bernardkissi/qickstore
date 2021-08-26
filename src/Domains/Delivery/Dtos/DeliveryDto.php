<?php

namespace Domain\Delivery\Dtos;

use Carbon\Carbon;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;
use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\CAST_PRIMITIVES;
use Cerbero\LaravelDto\Dto;

/**
 * The data transfer object for the Delivery model.
 *
 * @property int $id
 * @property string $service
 * @property int $orderId
 * @property int $amount
 * @property string $state
 * @property string $deliveryCode
 * @property string|null $clientCode
 * @property string|null $estimateId
 * @property string|null $instructions
 * @property string|null $downloadLink
 * @property string|null $error
 * @property string|null $deliveryAddress
 * @property string|null $deliveryDetails
 * @property Carbon|null $completedAt
 * @property Carbon|null $failedAt
 * @property string $reference
 * @property float $latitude
 * @property float $longitude
 * @property string $estimateId
 * @property string $country_code
 * @property array $pickup
 * @property array $dropoff
 * @property mixed $items
 * @property array $contact
 * @property string $estimate_id
 */
class DeliveryDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES | CAST_PRIMITIVES;

    /**
     * Default values
     *
     * @var array
     */
    protected static $defaultValues = [

        'country_code' => 'GH',
    ];
}
