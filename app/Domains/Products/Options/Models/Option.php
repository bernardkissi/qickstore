<?php

namespace App\Domains\Products\Options\Models;

use App\Domains\Products\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domains\Products\Options\Models\Option
 *
 * @property int $id
 * @property int $option_type_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Domains\Products\Options\Models\OptionType $types
 * @method static \Illuminate\Database\Eloquent\Builder|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereOptionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Option extends Model
{
    use HasFactory;

    /**
     * Fillable properties of this class
     *
     * @var array
     */
    protected $fillable = ['name', 'option_type_id'];

    /**
     *  Option types relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function types()
    {
        return $this->belongsTo(OptionType::class, 'option_type_id', 'id');
    }

    //is_filterable

    /**
     * Product Options relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
