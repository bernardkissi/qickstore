<?php

namespace App\Domains\Delivery\Model;

use App\Domains\Delivery\States\DeliveryState;
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
        'service',
        'delivery_address',
        'delivery_details',
        'delivery_code',
        'client_code',
        'estimate_id',
        'instructions',
        'download_link',
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
    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
