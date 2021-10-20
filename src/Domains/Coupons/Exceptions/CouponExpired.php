<?php

namespace Domain\Coupons\Exceptions;

use Domain\Coupons\Coupon;
use Exception;

class CouponExpired extends Exception
{
    protected $message = 'The voucher is already expired.';

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
