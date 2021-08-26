<?php

namespace Domain\Payouts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
