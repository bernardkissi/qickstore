<?php

namespace Domain\User;

use Database\Factories\VisitorFactory;
use Domain\Coupons\Traits\CanRedeemCoupon;
use Domain\Orders\Order;
use Domain\Products\Skus\Sku;
use Domain\Subscription\ProductSubscription;
use Domain\User\Traits\HasAddress;
use Domain\User\Traits\ManagesAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Visitor extends Model
{
    use
    HasFactory,
    ManagesAddress,
    CanRedeemCoupon,
    HasAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'email',
        'mobile',
    ];

    /**
     * Visitor cart relationship
     *
     * @return MorphToMany
     */
    public function cart(): MorphToMany
    {
        return $this->morphToMany(Sku::class, 'cartable', 'cart_customer')
            ->withPivot(['quantity', 'in_bundle', 'discount']);
    }

    /**
     * Get all of the vistor's orders.
     *
     * @return MorphMany
     */
    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    /**
     * Get all of the vistor's orders.
     *
     * @return MorphMany
     */
    public function subscriptions(): HasManyThrough
    {
        return $this->hasManyThrough(ProductSubscription::class, Order::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return VisitorFactory::new();
    }
}
