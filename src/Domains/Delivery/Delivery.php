<?php

namespace Domain\Delivery;

use Carbon\Carbon;
use Domain\Delivery\States\DeliveryState;
use Domain\Delivery\Traits\CanTransitionDelivery;
use Domain\Orders\Order;
use Domain\Orders\Traits\HasTransitionTimeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesMills\Uuid\HasUuidTrait;
use Spatie\ModelStates\HasStates;

class Delivery extends Model
{
    use
    HasFactory,
    SoftDeletes,
    HasUuidTrait,
    CanTransitionDelivery,
    HasTransitionTimeline,
    HasStates;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [

        'service',
        'order_id',
        'status',
        'reference',
        'tracking_code',
        'provider_code',
        'estimate_id',
        'instructions',
        'download_link',
        'agent_details',
        'vehicle_type',
        'error',
        'completed_at',
        'failed_at',
        'updates',
    ];

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'state' => DeliveryState::class,
    ];

    /**
     * Order delivery relations
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Returns deliveries which have not been updated in the last 4 hours.
     *
     * @return Builder
     */
    public function scopeUpdateDue($query): Builder
    {
        return $query->whereNotIn('state', ['delivering', 'delivered'])
            ->where('updated_at', '<', Carbon::parse('-4 hours'));
    }
}
