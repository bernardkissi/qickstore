<?php

namespace Domain\Products\Product;

use Domain\Products\Product\Casts\Currency;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

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
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     *  Product sku relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\morphOne
     */
    public function sku()
    {
        return $this->morphOne(Sku::class, 'skuable');
    }
}
