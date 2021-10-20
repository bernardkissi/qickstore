<?php

namespace Domain\Coupons\Services;

use Domain\Coupons\Coupon;
use Domain\Coupons\Exceptions\CouponExpired;
use Domain\Coupons\Exceptions\CouponIsInvalid;
use Domain\Coupons\Services\CouponGenerator;
use Illuminate\Database\Eloquent\Model;

class Coupons
{
    /**
     * Coupon generator
     *
     * @var CouponGenerator
     */
    private $generator;

    public function __construct(CouponGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generate the specified amount of codes and return codes
     *
     * @param int $amount
     * @return array
     */
    public function generate(?string $prefix, int $amount = 1): array
    {
        $codes = [];

        for ($i = 1; $i <= $amount; $i++) {
            $codes[] = $this->getUniqueCoupon(prefix: $prefix);
        }

        return $codes;
    }

    /**
     * Creates a coupon
     *
     * @param Model $model
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return array
     */
    public function create(array $data, int $amount = 1)
    {
        $coupons = [];

        $prefix = $data['prefix'] ?? config('coupons.prefix');

        foreach ($this->generate($prefix, $amount) as $couponCode) {
            $coupons[] = Coupon::create([
                'code' => $couponCode,
                'type' => $data['type'],
                'discount' => $data['discount'],
                'min_value_required' => $data['min_value_required'] ?? null,
                'usage_limit' => $data['usage_limit'] ?? null,
                'expires_at' => $data['expires_at'] ?? null,
            ]);
        }

        return $coupons;
    }


    /**
     * Checks the validity of the coupon
     *
     * @param string $code
     * @throws VoucherIsInvalid
     * @throws VoucherExpired
     * @return Voucher
     */
    public function check(string $code)
    {
        $coupon = Coupon::whereCode($code)->first();

        if ($coupon === null) {
            throw CouponIsInvalid::withCode($code);
        }
        if ($coupon->isExpired()) {
            throw CouponExpired::create($coupon);
        }

        return $coupon;
    }

    /**
     * Expire code as it won't be usable anymore.
     *
     * @param string $code
     * @return bool
     * @throws CouponIsInvalid
     */
    public function disable($code)
    {
        $coupon = Coupon::whereCode($code)->first();

        if ($coupon === null) {
            throw CouponIsInvalid::withCode($code);
        }

        $coupon->expires_at = now()->toDateTimeString();
        $coupon->usage_limit = 0;

        return $coupon->save();
    }

    /**
     * Clear all expired and used promotion codes
     * that can not be used anymore.
     *
     * @return void
     */
    public function clearRedundant()
    {
        Coupon::all()->each(function (Coupon $coupon) {
            if ($coupon->isExpired() || $coupon->users()->exits()) {
                $coupon->users()->detach();
                $coupon->delete();
            }

            if ($coupon->isExpired() || $coupon->visitors()->exits()) {
                $coupon->visitors()->detach();
                $coupon->delete();
            }
        });
    }

    /**
     * Generates a unique coupon code
     *
     * @return string
     */
    protected function getUniqueCoupon(?string $prefix = null): string
    {
        $coupon = $this->generator->setPrefix($prefix)->generateUnique();

        while (Coupon::whereCode($coupon)->count() > 0) {
            $coupon = $this->generator->generateUnique();
        }

        return $coupon;
    }
}
