<?php

namespace App\Domains\Products\Skus\Model;

use App\Domains\Products\Product\Models\Product;
use App\Domains\Products\Skus\Collection\SkuCollection;
use App\Domains\Products\Skus\Traits\ImageHandler;
use App\Domains\Products\Skus\Traits\TrackStock;
use App\Domains\Products\Stocks\Models\Stock;
use App\Domains\Products\Stocks\Models\StockView;
use App\Domains\User\User;
use App\Domains\User\Visitor;
use Database\Factories\SkuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Sku extends Model implements HasMedia
{
    use
    HasFactory,
    InteractsWithMedia,
    ImageHandler,
    TrackStock;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [

        'code',
        'price',
        'unlimited',
        'min_stock',
        'skuable_id',
        'skuable_type',
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
     * @return Illuminate\Database\Eloquent\Concerns\morphTo
     */
    public function skuable()
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
     * @return  Illuminate\Database\Eloquent\Concerns\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Product stock relationship
     *
     * @return  Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Sku product stock count relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stockCount(): HasOne
    {
        return $this->hasOne(StockView::class);
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
}
