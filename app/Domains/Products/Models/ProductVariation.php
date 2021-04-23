<?php

namespace App\Domains\Products\Models;

use App\Domains\Products\Models\Product;
use App\Domains\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;


     /**
     * Fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'price',
        'order',
        'properties',
        'identifier',
        'barcode',
        'status'
    ];


     /**
     *  Variation product relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
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
}
