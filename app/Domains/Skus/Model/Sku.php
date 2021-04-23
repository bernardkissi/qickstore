<?php

namespace App\Domains\Skus\Model;

use App\Domains\Stocks\Models\StockView;
use Database\Factories\SkuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sku extends Model
{
    use HasFactory;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [
        
        'code',
        'price',
        'skuable_id',
        'skuable_type'
    ];
    

    /**
     * Skuable model relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\morphTo
     */
    public function skuable()
    {
        return $this->morphTo();
    }


    /**
     * Product sku relationship
     *
     * @return  Illuminate\Database\Eloquent\Concerns\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    /**
     * Product stock relationship
     *
     * @return  Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }


    /**
     * Sku product stock count relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stockCount(): HasOne
    {
        return $this->hasOne(StockView::class, 'sk_id');
    }


    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SkuFactory::new();
    }
}
