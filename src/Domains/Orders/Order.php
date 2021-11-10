<?php

namespace Domain\Orders;

use Domain\Coupons\Coupon;
use Domain\Delivery\Delivery;
use Domain\Delivery\ShippingProvider;
use Domain\Disputes\Dispute;
use Domain\Orders\Traits\CanTransitionOrder;
use Domain\Orders\Traits\ManagesOrderDelivery;
use Domain\Orders\Traits\ManageSubscription;
use Domain\Payments\Payment;
use Domain\Products\Skus\Sku;
use Domain\Refunds\Refund;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;
use JamesMills\Uuid\HasUuidTrait;

class Order extends Model
{
    use
    HasFactory,
    ManagesOrderDelivery,
    HasUuidTrait,
    CanTransitionOrder,
    ManageSubscription,
    Notifiable;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [

        'status',
        'order_id',
        'total',
        'discount',
        'items_count',
        'shipping_id',
        'address_id',
        'shipping_service',
        'error_message',
        'shipping_cost',
        'payment_gateway',
        'instructions',
        'coupon_id',
    ];

    /**
     * Get the parent commentable model (user or visitor).
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

    /**
     * Returns the shipping provider ascociated with an order
     *
     * @return BelongsTo
     */
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(ShippingProvider::class);
    }

    /**
     * Returns the address associated with an order
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Returns the coupon associated with an order
     *
     * @return BelongsTo
     */
    public function coupon(): HasOne
    {
        return $this->hasOne(Coupon::class);
    }

    /**
     * Returns the refund for the order
     *
     * @return HasOneThrough
     */
    public function refund(): HasOneThrough
    {
        return $this->hasOneThrough(Refund::class, Dispute::class);
    }

    /**
     *  Returns the dispute associated with an order
     *
     * @return MorphOne
     */
    public function dispute(): MorphOne
    {
        return $this->morphOne(Dispute::class, 'disputable');
    }

    /**
     * Model Booting method
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($order) {
            $order->status()->create([]);
        });
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
