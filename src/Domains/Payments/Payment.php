<?php

namespace Domain\Payments;

use Domain\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

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
        'access_code',
        'pay_url'
    ];

    /**
     * Register payments for order
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
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
