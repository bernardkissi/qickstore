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

    /**
     * checks if subscription exist
     *
     * @param string $subscription_code
     *
     * @return bool
     */
    public static function subscriptionExist(string $subscriptionCode): bool
    {
        return self::where('subscription_code', $subscriptionCode)->exists();
    }

    /**
     * checks if subscription exist
     *
     * @param string $subscription_code
     *
     * @return bool
     */
    public static function checkState(string $subscriptionCode): bool
    {
        return self::firstWhere('subscription_code', $subscriptionCode)->state;
    }
}
