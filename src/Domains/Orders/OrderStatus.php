<?php

namespace Domain\Orders;

use Domain\Orders\States\OrderState;
use Domain\Orders\Traits\HasTransitionTimeline;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class OrderStatus extends Model
{
    use
    HasFactory,
    HasStates,
    HasTransitionTimeline;

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
        'cancelled_reason',
        'history',
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
        'history' => 'array',
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
}
