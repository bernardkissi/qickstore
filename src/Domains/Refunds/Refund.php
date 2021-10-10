<?php

namespace Domain\Refunds;

use Domain\Refunds\Dispute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Refund extends Model
{
    use
    SoftDeletes,
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
        'status'
    ];

    /**
    * Database table for this model
    *
    * @var string
    */
    protected $table = 'refunds';

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
