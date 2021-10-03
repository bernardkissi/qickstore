<?php

declare(strict_types=1);

namespace Domain\Products\Product;

use Database\Factories\ProductFactory;
use Domain\Products\Attributes\Attribute;
use Domain\Products\Categories\Category;
use Domain\Products\Collections\Models\Collection;
use Domain\Products\Options\Option;
use Domain\Products\Product\Casts\Currency;
use Domain\Products\Product\Scopes\Scoper;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesMills\Uuid\HasUuidTrait;

class Product extends Model
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
        'description',
        'slug',
        'status',
        'featured',
        'schedule_at',
        'category_id'
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
     *  Route key returned
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     *  Product belongs to category relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Product has options relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class);
    }

    /**
     *  Product has variations relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'desc');
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

    /**
     *  Product collections relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\morphOne
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }

    /**
     *  Product properties relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasMany
     */
    public function filters()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * Scopes filter on model
     *
     * @param  Builder $builder
     * @param  array   $scopes
     *
     * @return Builder
     */
    public function scopeWithFilter(Builder $builder, $scopes = [])
    {
        return (new Scoper(request()))->apply($builder, $scopes);
    }

    /**
     * Scope to check if product has variations
     *
     * @return bool
     */
    public function scopeHasVariation(): bool
    {
        return self::has('variations');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
