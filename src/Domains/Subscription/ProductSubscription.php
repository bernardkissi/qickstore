<?php

namespace Domain\Subscription;

use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use JamesMills\Uuid\HasUuidTrait;
use Spatie\ModelStates\HasStates;

class ProductSubscription extends Model
{
    use
    HasStates,
    HasUuidTrait,
    HasFactory;

    /**
    * Fillable properties of the model.
    *
    * @var array
    */
    public $fillable = [

        'sku_id',
        'order_id',
        'auth_code',
        'subscription_code',
        'email_token',
        'channel',
        'card_type',
        'plan_id',
        'plan_code',
        'customer_code',
        'customer_email',
        'invoice_limit',
        'start_date',
        'end_date',
        'next_billing_date',
        'subscription_id',
        'cron_expression',
        'status',
    ];

    /**
     * Returns the product subscribed to.
     *
     * @return HasOne
     */
    public function sku(): HasOne
    {
        return $this->hasOne(Sku::class);
    }
}
