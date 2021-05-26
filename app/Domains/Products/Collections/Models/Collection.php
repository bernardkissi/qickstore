<?php

namespace App\Domains\Products\Collections\Models;

use App\Domains\Products\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domains\Products\Collections\Models\Collection
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Product> $products
 * @property-read int|null $products_count
 */
class Collection extends Model
{
    use HasFactory;

    /**
     * Fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = ['name','description', 'image'];

    /**
     *  Product belongs to category relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
