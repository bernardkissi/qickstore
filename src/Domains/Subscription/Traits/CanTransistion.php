<?php

declare(strict_types=1);

namespace Domain\Subscription\Traits;

trait CanTransistion
{
    public static function transitioning(string $subscriptionCode, string $state)
    {
        $subscription = self::firstWhere('subscription_code', $subscriptionCode);

        if ($subscription->state->canTransitionTo($state)) {
            $subscription->state->transitionTo($state);
        }
    }
}
