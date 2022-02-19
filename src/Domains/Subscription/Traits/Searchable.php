<?php

declare(strict_types=1);

namespace Domain\Subscription\Traits;

trait Searchable
{
    public static function searchSubscription(string $planCode, string $authCode)
    {
        return self::query()->where('plan_code', $planCode)
            ->where('auth_code', $authCode)
            ->first();
    }
}
