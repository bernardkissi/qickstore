<?php

namespace Domain\Products\Product;

use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesMills\Uuid\HasUuidTrait;

class Bundle extends Model
{
    use
    HasUuidTrait,
    SoftDeletes,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'description',
        'slug',
        'is_active',
        'schedule_at',
        'bundle_price',
        'percentage_decrease'
    ];


    /**
     * Returns the associated products
     *
     * @return BelongsToMany
     */
    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'bundle_product');
    }
}
