<?php

namespace App\Domains\User;

use App\Domains\Orders\Model\Order;
use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Domains\user\Guest
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Sku[] $carts
 * @property-read int|null $carts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Guest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest query()
 * @mixin \Eloquent
 */
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
        'mobile'
    ];

    /**
    * Visitor cart relationship
    *
    * @return MorphToMany
    */
    public function cart(): MorphToMany
    {
        return $this->morphToMany(Sku::class, 'cartable');
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
