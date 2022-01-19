<?php

namespace Domain\Payments;

use Domain\Orders\Order;
use Domain\Subscription\ProductSubscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesMills\Uuid\HasUuidTrait;

class Payment extends Model
{
    use
    SoftDeletes,
    HasUuidTrait,
    HasFactory;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [
        'tx_ref',
        'provider_reference',
        'status',
        'amount',
        'provider',
        'channel',
        'order_id',
        'subscription_id',
        'access_code',
        'pay_url',
        'history',
        'currency',
        'customer_code',
        'authorization_code',
        'ip_address',
        'paid_at',
        'deleted_at',
    ];

    /**
     * Model table name
     *
     * @var string
     */
    protected $table = 'transcations';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'history' => 'array',
    ];

    /**
     * Returns payments for an order
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Returns the product the payment is subscribed to.
     *
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(ProductSubscription::class);
    }

    /**
     * Returns an order of the payment
     *
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}
