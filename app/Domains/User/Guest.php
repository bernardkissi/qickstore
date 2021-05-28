<?php

namespace App\Domains\User;

use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
class Guest extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'deviceId',
        'email',
        'mobile'
    ];

    /**
    * Guest cart relationship
    *
    * @return MorphToMany
    */
    public function cart(): MorphToMany
    {
        return $this->morphToMany(Sku::class, 'cartable');
    }
}
