<?php

namespace Domain\Products\Product;

use Database\Factories\ProductVariationFactory;
use Domain\Products\Product\Casts\Currency;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use JamesMills\Uuid\HasUuidTrait;

class ProductVariation extends Model
{
    use
    HasUuidTrait,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'price',
        'order',
        'slug',
        'properties',
        'identifier',
        'barcode',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

        'price' => Currency::class.':GHS',
    ];

    /**
     *  Variation product relationship
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     *  Product sku relationship
     *
     * @return MorphOne
     */
    public function sku(): MorphOne
    {
        return $this->morphOne(Sku::class, 'skuable');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ProductVariationFactory::new();
    }
}
