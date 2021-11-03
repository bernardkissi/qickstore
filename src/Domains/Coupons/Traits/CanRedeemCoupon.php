<?php

declare(strict_types=1);

namespace Domain\Coupons\Traits;

use Carbon\Carbon;
use Domain\Cart\Facade\Cart;
use Domain\Coupons\Coupon;
use Domain\Coupons\Exceptions\CouponExpired;
use Domain\Coupons\Exceptions\CouponIsInvalid;
use Domain\Coupons\Exceptions\CouponLImitReached;
use Domain\Coupons\Exceptions\CouponMinValueRequired;
use Domain\Coupons\Exceptions\CouponRedeemed;
use Domain\Coupons\Facade\Coupon as Coupons;
use Domain\User\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Cache;

trait CanRedeemCoupon
{
    /**
     * @param string $code
     *
     * @throws CouponExpired
     * @throws CouponIsInvalid
     * @throws CouponRedeemed
     *
     * @return mixed
     */
    public function redeemCode(string $code)
    {
        $coupon = Coupons::check($code);

        if (! is_null($coupon->usage_limit) && $this->checkOverUsedLimit($coupon)) {
            throw CouponLImitReached::create($coupon);
        }

        if (! is_null($coupon->min_value_required) && ! $this->checkOrderTotalRequired($coupon)) {
            throw CouponMinValueRequired::withCode($coupon);
        }

        $users = $this instanceof User ? $coupon->users() : $coupon->visitors();

        if ($users->wherePivot('couponable_id', $this->id)->exists()) {
            throw CouponRedeemed::create($coupon);
        }
        if ($coupon->isExpired()) {
            throw CouponExpired::create($coupon);
        }

        $this->coupons()->attach($coupon, [
            'redeemed_at' => Carbon::now(),
        ]);

        if (! is_null($coupon->usage_limit)) {
            $coupon->used += 1;
            $coupon->save();
        }

        $this->persistInCache($coupon);

        return $coupon;
    }

    /**
     * @param Coupon $coupon
     *
     * @throws CouponExpired
     * @throws CouponIsInvalid
     * @throws CouponRedeemed
     *
     * @return mixed
     */
    public function redeemCoupon(Coupon $coupon)
    {
        return $this->redeemCode($coupon->code);
    }

    /**
     * Check if coupon has reached its usage limit.
     *
     * @param Coupon $coupon
     *
     * @return bool
     */
    public function checkOverUsedLimit(Coupon $coupon): bool
    {
        return $coupon->used >= $coupon->usage_limit;
    }

    /**
     * Checks if the order total surpasses the min_required value.
     *
     * @param Coupon $coupon
     *
     * @return bool
     */
    public function checkOrderTotalRequired(Coupon $coupon): bool
    {
        return Cart::subTotal()->getAmount() >= $coupon->min_value_required;
    }

    /**
     * Persist the coupon in the cache.
     *
     * @param Coupon $coupon
     *
     * @return void
     */
    public function persistInCache(Coupon $coupon): void
    {
        $name = $this->identifier;
        Cache::put("${name}-coupon", $coupon, 3600);
    }

    /**
     * Get coupon information related to the user
     *
     * @return MorphToMany
     */
    public function coupons(): MorphToMany
    {
        return $this->morphToMany(Coupon::class, 'couponable');
    }
}
