<?php

declare(strict_types=1);

namespace App\Domains\Stocks\Models;

use App\Domains\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockView extends Model
{
    use HasFactory;

    /**
     *  Custom model table
     *
     * @var string
     */
    protected $table = 'product_stock_view';


     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    /**
     * Product stock count
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku(): BelongsTo
    {
        return belongsTo(Sku::class);
    }
}
