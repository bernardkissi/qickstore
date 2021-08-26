<?php

declare(strict_types=1);

namespace Domain\User\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;
use const Cerbero\Dto\CAST_PRIMITIVES;
use const Cerbero\Dto\PARTIAL;
use Domain\Orders\Dtos\OrderData;

/**
 * The data transfer object for the Visitor model.
 *
 * @property Carbon|null $createdAt
 * @property string|null $email
 * @property int $id
 * @property string $identifier
 * @property string|null $mobile
 * @property Carbon|null $updatedAt
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
