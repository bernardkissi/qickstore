<?php

namespace Domain\Products\Stocks;

use Database\Factories\StockFactory;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     *  Stock attributes
     *
     * @var array
     */
    protected $fillable = ['quantity'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Product sku relationship
     *
     * @return  Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return StockFactory::new();
    }
}
