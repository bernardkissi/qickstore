<?php

namespace App\Domains\Orders\Model\Dtos;

use App\Domains\Products\Skus\Model\Dtos\SkuData;
use Carbon\Carbon;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;
use const Cerbero\Dto\PARTIAL;
use Cerbero\LaravelDto\Dto;

/**
 * The data transfer object for the Order model.
 *
 * @property Carbon|null $createdAt
 * @property string|null $errorMessage
 * @property Carbon|null $failedAt
 * @property int $id
 * @property int $orderableId
 * @property string $orderableType
 * @property string $state
 * @property int $subtotal
 * @property Carbon|null $updatedAt
 * @property array<SkuData> $products
 */
class OrderData extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
