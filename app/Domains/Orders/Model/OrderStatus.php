<?php

namespace App\Domains\Orders\Model;

use App\Domains\Orders\States\OrderState;
use App\Domains\Orders\Traits\HasStateTransistions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class OrderStatus extends Model
{
    use
    HasFactory,
    HasStates,
    HasStateTransistions;

    const PENDING = 1;
    const CANCELLED = 2;
    const FAILED = 3;
    const PAID = 4;
    const SHIPPED = 5;
    const DELIVERED = 6;
    const REFUNDED = 7;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [
        'state',
        'failed_at',
        'cancelled_at',
        'failed_message',
        'cancelled_reason'
    ];

    /**
     * Database table for this model
     *
     * @var string
     */
    protected $table = 'order_status';

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'state' => OrderState::class,
    ];

    /**
     * Returns orders for a status
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Returns state arrangement order number
     *
     * @param string $state
     * @return void
     */
    public function generateOrder(string $state): int
    {
        return match ($state) {
            'pending' => self::PENDING,
            'cancelled' => self::CANCELLED,
            'failed' => self::FAILED,
            'paid' => self::PAID,
            'shipped' => self::SHIPPED,
            'delivered' => self::DELIVERED,
            'refunded' => self::REFUNDED,
        };
    }
}
