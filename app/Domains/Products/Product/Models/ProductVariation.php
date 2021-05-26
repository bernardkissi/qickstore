<?php

namespace App\Domains\Products\Product\Models;

use App\Domains\Products\Product\Casts\Currency;
use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domains\Products\Product\Models\ProductVariation
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property mixed|null $price
 * @property int|null $order
 * @property mixed|null $properties
 * @property string|null $identifier
 * @property string|null $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read Product $product
 * @property-read Sku|null $sku
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
