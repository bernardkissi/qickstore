<?php

namespace Domain\Payouts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;

    /**
     * Model properties
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'branch_code',
        'branch_name',
        'swift_code',
        'bic',
    ];

    /*5
     * Returns banks branches
     *
     * @return HasMany
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
