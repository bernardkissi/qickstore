<?php

namespace App\Domains\Orders\Model;

use App\Domains\Delivery\Model\Delivery;
use App\Domains\Orders\Model\OrderStatus;
use App\Domains\Orders\Traits\HandlesMultipleDeliveryOrderTransition;
use App\Domains\Orders\Traits\ManagesOrderDelivery;
use App\Domains\Payments\Model\Payment;
use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use
    HasFactory,
    ManagesOrderDelivery,
    HandlesMultipleDeliveryOrderTransition,
    Notifiable;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [

        'status',
        'order_id',
        'subtotal',
        'service',
        'error_message'
    ];

    /**
     * Get the parent commentable model (user or guest).
     *
     * @return MorphTo
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all products associated with order
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'product_order')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }

    /**
     * Returns the payment for an order
     *
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Returns the status for an order
     *
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(OrderStatus::class);
    }

    /**
     * Returns the delivery state of an order
     *
     * @return HasOne
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
