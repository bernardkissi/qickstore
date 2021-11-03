<?php

namespace Domain\Payouts;

use Domain\Refunds\Dispute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Payout extends Model
{
    use HasFactory;

    /**
     * Model properties
     *
     * @var array
     */
    protected $fillable = [
        'payout_id',
        'account_number',
        'bank_name',
        'fullname',
        'currency',
        'amount_requested',
        'transaction_fee',
        'status',
        'reference',
        'narration',
        'requires_approval',
        'is_approved',
        'error',
    ];

    /**
     * Returns the dispute associated with a payout
     *
     * @return MorphOne
     */
    public function dispute(): MorphOne
    {
        return $this->morphOne(Dispute::class, 'disputable');
    }
}
