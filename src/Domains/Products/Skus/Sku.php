<?php

namespace Domain\Products\Skus;

use App\Helpers\Scopes\Scoper;
use Database\Factories\SkuFactory;
use Domain\Products\Product\Product;
use Domain\Products\Skus\Collection\SkuCollection;
use Domain\Products\Skus\Traits\CanBeBundled;
use Domain\Products\Skus\Traits\ImageHandler;
use Domain\Products\Skus\Traits\TrackStock;
use Domain\Products\Stocks\Stock;
use Domain\Products\Stocks\StockView;
use Domain\User\User;
use Domain\User\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use JamesMills\Uuid\HasUuidTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Sku extends Model implements HasMedia
{
    use
    HasFactory,
    InteractsWithMedia,
    HasUuidTrait,
    ImageHandler,
    CanBeBundled,
    TrackStock;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'compare_price',
        'unlimited',
        'min_stock',
        'skuable_id',
        'skuable_type',
        'discount_percentage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'unlimited' => 'boolean',
    ];

    /**
     * Skuable model relationship
     *
     * @return morphTo
     */
    public function skuable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Cart user relationship
     *
     * @return void
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'cartable');
    }

    /**
     * Cart visitors relationship
     *
     * @return void
     */
    public function visitors()
    {
        return $this->morphedByMany(Visitor::class, 'cartable');
    }

    /**
     * Product sku relationship
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Product stock relationship
     *
     * @return HasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Returns the associated products
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Bundle::class, 'bundle_product');
    }

    /**
     * Sku product stock count relationship
     *
     * @return HasOne
     */
    public function stockCount(): HasOne
    {
        return $this->hasOne(StockView::class);
    }

    /**
     * Sku product stock count relationship
     *
     * @return BelongsToMany
     */
    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Bundle::class);
    }

    /**
     * Returns sales belognging to a product
     *
     * @return BelongsToMany
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'sale_product');
    }

    /**
     * Defining image conversion on model
     *
     * @param Media $media
     *
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->quality(70);
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
     * Returns a new custom sku collection
     *
     * @param array $models
     *
     * @return void
     */
    public function newCollection(array $models = [])
    {
        return new SkuCollection($models);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SkuFactory::new();
    }

    // /**
    //  * Model Booting method
    //  *
    //  * @return void
    //  */
    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($sku) {
    //         $sku->uuid = (string) Str::uuid();
    //     });
    // }
}
