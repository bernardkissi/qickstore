<?php

namespace App\Domains\Orders\Model;

use App\Domains\Orders\States\OrderState;
use App\Domains\Payments\Model\Payment;
use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\ModelStates\HasStates;

class Order extends Model
{
    use HasFactory, HasStates;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [

        'status',
        'order_id',
        'subtotal',
    ];

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'state' => OrderState::class,
    ];

    /**
     * Get the parent commentable model (user or guest).
     *
     * @return MorphTo
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all products associated with order
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'products_order')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }

    /**
     * Returns the payment for an order
     *
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
