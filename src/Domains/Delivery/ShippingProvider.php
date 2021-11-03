<?php

namespace Domain\Delivery;

use Database\Factories\ShippingProviderFactory;
use Domain\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesMills\Uuid\HasUuidTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShippingProvider extends Model implements HasMedia
{
    use
    HasFactory,
    SoftDeletes,
    HasUuidTrait,
    InteractsWithMedia;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'constraints',
        'slug',
    ];

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'constraints' => 'array',
    ];

    /**
     * Defining image conversion on model
     *
     * @param Media $media
     *
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('logo')
            ->width(368)
            ->height(232)
            ->quality(70);
    }

    /**
     * Return the orders of the shipping provider
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ShippingProviderFactory::new();
    }
}
