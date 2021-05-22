<?php

declare(strict_types=1);

namespace App\Domains\Products\Categories\Models;

use App\Domains\Products\Attributes\Models\Attribute;
use App\Domains\Products\Categories\Scopes\Scopes;
use App\Domains\Products\Product\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domains\Products\Categories\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Category> $subcategories
 * @property-read int|null $subcategories_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Category categories()
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Attribute> $filters
 * @property-read int|null $filters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Product> $products
 * @property-read int|null $products_count
 */
class Category extends Model
{
    use HasFactory, Scopes;

    /**
     * Fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = ['name','slug', 'order'];

    /**
     * Subcategory relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     *  Category products relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the deployments for the project.
     */
    public function filters()
    {
        return $this->hasManyThrough(Attribute::class, Product::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
