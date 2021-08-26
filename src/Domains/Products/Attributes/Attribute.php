<?php

namespace Domain\Products\Attributes;

use Domain\Products\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [ 'property_name', 'property_value' ];

    /**
     *  Database table name
     *
     * @var string
     */
    protected $table = 'filters';

    /**
     * Product has options relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
