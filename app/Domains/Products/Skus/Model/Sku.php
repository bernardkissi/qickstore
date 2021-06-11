<?php

namespace App\Domains\Products\Skus\Model;

use App\Domains\Products\Product\Models\Product;
use App\Domains\Products\Skus\Traits\TrackStock;
use App\Domains\Products\Stocks\Models\Stock;
use App\Domains\Products\Stocks\Models\StockView;
use App\Domains\User\User;
use App\Domains\User\Visitor;
use Database\Factories\SkuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Domains\Products\Skus\Model\Sku
 *
 * @property int $id
 * @property string $skuable_type
 * @property int $skuable_id
 * @property string $code
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $min_stock
 * @property bool $unlimited
 * @property-read Model|\Eloquent $skuable
 * @property-read StockView|null $stockCount
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Stock> $stocks
 * @property-read int|null $stocks_count
 * @method static \Database\Factories\SkuFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sku query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereMinStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereSkuableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereSkuableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereUnlimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|Guest[] $guests
 * @property-read int|null $guests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read int|null $users_count
 */
class Sku extends Model
{
    use
    HasFactory,
    TrackStock;

    /**
     * Fillable properties of the model
     *
     * @var array
     */
    protected $fillable = [

        'code',
        'price',
        'unlimited',
        'min_stock',
        'skuable_id',
        'skuable_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'unlimited' => 'boolean',
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
     * Cart user relationship
     *
     * @return void
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'cartable');
    }

    /**
     * Cart visitors relationship
     *
     * @return void
     */
    public function visitors()
    {
        return $this->morphedByMany(Visitor::class, 'cartable');
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
        return $this->hasOne(StockView::class);

        // return $this->belongsToMany(Sku::class, 'product_stock_view')
        // ->withPivot(['stock']);
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
