<?php

declare(strict_types=1);

namespace App\Domains\Products\Stocks\Models;

use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Domains\Products\Stocks\Models\StockView
 *
 * @property int $sku_id
 * @property string $code
 * @property string $stock
 * @property-read Sku $sku
 * @method static \Illuminate\Database\Eloquent\Builder|StockView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockView query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockView whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockView whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockView whereStock($value)
 * @mixin \Eloquent
 */
class StockView extends Model
{
    use HasFactory;

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
     *  Custom model table
     *
     * @var string
     */
    protected $table = 'product_stock_view';

    /**
     * Product stock count
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}
