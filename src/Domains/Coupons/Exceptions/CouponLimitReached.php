<?php

namespace Domain\Coupons\Exceptions;

use Domain\Coupons\Coupon;
use Exception;

class CouponLimitReached extends Exception
{
    protected $message = 'The coupon has reached usage limit.';

    protected $coupon;


    public static function create(Coupon $coupon)
    {
        return new static($coupon);
    }


    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
}
