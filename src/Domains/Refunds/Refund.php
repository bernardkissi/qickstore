<?php

namespace Domain\Refunds;

use Domain\Disputes\Dispute;
use Domain\Refunds\States\RefundState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;

class Refund extends Model
{
    use
    SoftDeletes,
    HasStates,
    InteractsWithMedia,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [
        'dispute_id',
        'refund_id',
        'expected_at',
        'refund_reason',
        'refund_amount',
        'refund_at',
        'transcation_reference',
        'state',
    ];

    /**
     * Database table for this model
     *
     * @var string
     */
    protected $table = 'refunds';

    /**
     * Cast properties of the model
     *
     * @var array
     */
    protected $casts = [
        'state' => RefundState::class,
    ];

    /**
     * Returns dispute for refund
     *
     * @return HasOne
     */
    public function dispute(): HasOne
    {
        return $this->hasOne(Dispute::class);
    }
}
