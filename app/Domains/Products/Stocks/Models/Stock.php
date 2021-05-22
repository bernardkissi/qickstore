<?php

namespace App\Domains\Products\Stocks\Models;

use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domains\Products\Stocks\Models\Stock
 *
 * @property int $id
 * @property int $sku_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Sku $sku
 */
class Stock extends Model
{
    use HasFactory;

    /**
     *  Stock attributes
     *
     * @var array
     */
    protected $fillable = ['quantity', 'limit'];

    /**
     * Product sku relationship
     *
     * @return  Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
