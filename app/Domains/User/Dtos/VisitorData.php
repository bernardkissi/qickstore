<?php

declare(strict_types=1);

namespace App\Domains\User\Dtos;

use App\Domains\Orders\Model\Dtos\OrderData;
use App\Domains\Products\Skus\Model\Dtos\SkuData;
use Carbon\Carbon;
use const Cerbero\Dto\CAST_PRIMITIVES;
use const Cerbero\Dto\PARTIAL;
use Cerbero\LaravelDto\Dto;

/**
 * The data transfer object for the Visitor model.
 *
 * @property Carbon|null $createdAt
 * @property string|null $email
 * @property int $id
 * @property string $identifier
 * @property string|null $mobile
 * @property Carbon|null $updatedAt
 * @property array<SkuData> $cart
 * @property array<OrderData> $orders
 */
class VisitorData extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | CAST_PRIMITIVES;
}
