<?php

namespace Domain\Sales;

use Domain\Products\Skus\Sku;
use Domain\Sales\States\SalesState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesMills\Uuid\HasUuidTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;

class Sale extends Model
{
    use
    SoftDeletes,
    HasUuidTrait,
    HasStates,
    InteractsWithMedia,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [

        'banner_message',
        'container_id', //temp
        'starts_on',
        'ends_on',
        'percentage_reduction',
        'state',
    ];


    /**
    * Cast properties of the model
    *
    * @var array
    */
    protected $casts = [
        'state' => SalesState::class,
        'starts_on',
        'ends_on'
    ];


    public function changeState($state): void
    {
        if ($this->state->canTransitionTo($state)) {
            $this->state->transitionTo($state);
            //$status->updateTimeline($state);
        }
    }

    /**
     * Returns products belonging to a sale
     *
     * @return BelongsToMany
     */
    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'sale_product');
    }
}
