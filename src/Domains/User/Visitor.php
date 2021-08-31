<?php

namespace Domain\User;

use Domain\Orders\Order;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Visitor extends Model
{
    use HasFactory;

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
        return $this->morphToMany(Sku::class, 'cartable', 'cart_customer')->withPivot(['quantity']);
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
}