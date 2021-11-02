<?php

declare(strict_types=1);

namespace Domain\Products\Product;

use App\Helpers\Scopes\Scoper;
use Database\Factories\ProductFactory;
use Domain\Products\Attributes\Attribute;
use Domain\Products\Categories\Category;
use Domain\Products\Collections\Models\Collection;
use Domain\Products\Options\Option;
use Domain\Products\Product\Casts\Currency;
use Domain\Products\Skus\Sku;
use Domain\Products\Stocks\StockView;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
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
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Product has options relationship
     *
     * @return BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class);
    }

    /**
     *  Product has variations relationship
     *
     * @return HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'desc');
    }

    /**
     *  Product has plans relationship
     *
     * @return HasMany
     */
    public function plans(): HasMany
    {
        return $this->hasMany(ProductPlan::class)->orderBy('order', 'desc');
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
    * Get all of the deployments for the project.
    */
    public function stock()
    {
        return $this->hasOneThrough(StockView::class, Sku::class, 'skuable_id', 'sku_id');
    }

    /**
     *  Product collections relationship
     *
     * @return BelongsToMany
     */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }

    /**
     *  Product properties relationship
     *
     * @return HasMany
     */
    public function filters(): HasMany
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
    public function scopeWithFilter(Builder $builder, $scopes = []): Builder
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
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
}
