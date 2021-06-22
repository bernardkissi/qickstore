<?php

namespace App\Domains\Payments\Model;

use App\Domains\Orders\Model\Order;
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
}
