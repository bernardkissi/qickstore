<?php

namespace Domain\Coupons;

use Carbon\Carbon;
use Domain\User\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesMills\Uuid\HasUuidTrait;

class Coupon extends Model
{
    use
    HasUuidTrait,
    HasFactory;

    /**
     * Fillable properties of the model.
     *
     * @var array
     */
    public $fillable = [

        'is_active',
        'code', //temp
        'type',
        'discount',
        'usage_limit',
        'min_value_required',
        'used',
        'starts_at',
        'expires_at'
    ];

    /**
     * Coupon user relationship
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'couponable')
                ->withPivot(['redeemed_at', 'used']);
    }

    /**
     * Visitor user relationship
     */
    public function visitors()
    {
        return $this->morphedByMany(Visitor::class, 'couponable')
            ->withPivot(['redeemed_at', 'used']);
    }


    /**
     * Query builder to find promocode using code.
     *
     * @param $query
     * @param $code
     *
     * @return mixed
     */
    public function scopeWhereCode($query, $code): Builder
    {
        return $query->where('code', $code);
    }

    /**
     * Checks if the coupon is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at ? Carbon::now()->gte($this->expires_at) : false;
    }

    /**
     * Check if code is not expired.
     *
     * @return bool
     */
    public function isNotExpired(): bool
    {
        return ! $this->isExpired();
    }

    /**
     * Query builder to get expired promotion codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')->whereDate('expires_at', '<=', Carbon::now());
    }
}
