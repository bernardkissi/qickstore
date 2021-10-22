<?php

namespace Domain\Delivery;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use
    SpatialTrait,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [
        'country_code',
    ];

    /**
     * GeoSpatial fields of the model.
     *
     * @var array
     */
    protected $spatialFields = [
        'area'
    ];
}
