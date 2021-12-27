<?php

declare(strict_types=1);

namespace Domain\Subscription\Traits;

trait Searchable
{
    public static function searchSubscription(string $planCode, string $customerCode)
    {
        return self::query()->where('plan_code', $planCode)
            ->where('customer_code', $customerCode)
            ->first();
    }
}
