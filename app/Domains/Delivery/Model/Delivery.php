<?php

namespace App\Domains\Delivery\Model;

use App\Domains\Delivery\States\DeliveryState;
use App\Domains\Orders\Model\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class Delivery extends Model
{
    use HasFactory, HasStates;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [

        'service',
        'amount',
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

    /**
     * Manually set the state of the delivery.
     *
     * @param string $state
     * @return void
     */
    public function updateDeliveryStatus(string $state): void
    {
        if (!$this->state->canTransitionTo($state)) {
            //throw an exception
        }
        $this->state->transitionTo($state);
    }
}
