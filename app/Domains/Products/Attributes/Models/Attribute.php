<?php

namespace App\Domains\Products\Attributes\Models;

use App\Domains\Products\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domains\Products\Attributes\Models\Attribute
 *
 * @property int $id
 * @property int $product_id
 * @property string $property_name
 * @property string $property_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Product $products
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute wherePropertyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute wherePropertyValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    use HasFactory;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [ 'property_name', 'property_value' ];

    /**
     *  Database table name
     *
     * @var string
     */
    protected $table = 'filters';

    /**
     * Product has options relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
