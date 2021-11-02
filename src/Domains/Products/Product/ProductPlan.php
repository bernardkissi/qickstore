<?php

declare(strict_types=1);

namespace Domain\Products\Product;

use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProductPlan extends Model
{
    use HasFactory;

    /**
    * Fillable properties of the model.
    *
    * @var array
    */
    protected $fillable = [

        'plan_name',
        'plan_code',
        'price',
        'plan_description',
        'interval',
        'duration',
        'currency',
        'send_sms',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [

        'send_sms' => 'boolean',
    ];

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $table = 'product_plans';

    /**
     *  Product sku relationship
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     *  Product sku relationship
     *
     * @return MorphOne
     */
    public function sku(): MorphOne
    {
        return $this->morphOne(Sku::class, 'skuable');
    }
}
