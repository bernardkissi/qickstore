<?php

namespace Domain\Coupons\Exceptions;

use Domain\Coupons\Coupon;
use Exception;

class CouponRedeemed extends Exception
{
    protected $message = 'The coupon was already redeemed.';

    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public static function create(Coupon $coupon)
    {
        return new static($coupon);
    }
}
