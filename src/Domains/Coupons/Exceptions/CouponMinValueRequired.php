<?php

namespace Domain\Coupons\Exceptions;

use Cknow\Money\Money;

use Domain\Coupons\Coupon;
use Exception;

class CouponMinValueRequired extends Exception
{
    protected $message;

    public static function withCode(Coupon $coupon)
    {
        return new static('This coupon requires your order total to be greater than '
        .Money::GHS($coupon->min_value_required, 'GHS')->format());
    }

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getCouponCode()
    {
        return $this->code;
    }
}
