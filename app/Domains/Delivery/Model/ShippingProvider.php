<?php

namespace App\Domains\Delivery\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShippingProvider extends Model implements HasMedia
{
    use
    HasFactory,
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
        'slug'
    ];

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'constraints' => 'array'
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
}
