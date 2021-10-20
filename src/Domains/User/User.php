<?php

namespace Domain\User;

use Database\Factories\UserFactory;
use Domain\Coupons\Traits\CanRedeemCoupon;
use Domain\Orders\Order;
use Domain\Products\Skus\Sku;
use Domain\User\Traits\HasAddress;
use Domain\User\Traits\ManagesAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use
    HasFactory,
    Notifiable,
    ManagesAddress,
    CanRedeemCoupon,
    HasAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Undocumented function
     *
     * @return MorphToMany
     */
    public function cart(): MorphToMany
    {
        return $this->morphToMany(Sku::class, 'cartable', 'cart_customer')
            ->withPivot(['quantity', 'in_bundle', 'discount']);
    }

    /**
     * Get all of the user's orders.
     *
     * @return MorphMany
     */
    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'orderable');
    }


    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
