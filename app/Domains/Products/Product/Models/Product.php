<?php

declare(strict_types=1);

namespace App\Domains\Products\Product\Models;

use App\Domains\Products\Attributes\Models\Attribute;
use App\Domains\Products\Categories\Models\Category;
use App\Domains\Products\Collections\Models\Collection;
use App\Domains\Products\Options\Models\Option;
use App\Domains\Products\Product\Casts\Currency;
use App\Domains\Products\Product\Scopes\Scoper;
use App\Domains\Products\Product\Services\ProductImages\ImageHandler;
use App\Domains\Products\Skus\Model\Sku;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Domains\Products\Product\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property mixed|null $price
 * @property string|null $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $category_id
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Collection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Attribute> $filters
 * @property-read int|null $filters_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|array<Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Option> $options
 * @property-read int|null $options_count
 * @property-read Sku|null $sku
 * @property-read \Illuminate\Database\Eloquent\Collection|array<ProductVariation> $variations
 * @property-read int|null $variations_count
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static Builder|Product hasVariation()
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBarcode($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product withFilter($scopes = [])
 * @mixin \Eloquent
 */
class Product extends Model implements HasMedia
{
    use
    HasFactory,
    InteractsWithMedia,
    ImageHandler;

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
     * @param  Builder $builder [description]
     * @param  array   $scopes
     *
     * @return [type]           [description]
     */
    public function scopeWithFilter(Builder $builder, $scopes = [])
    {
        return (new Scoper(request()))->apply($builder, $scopes);
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
