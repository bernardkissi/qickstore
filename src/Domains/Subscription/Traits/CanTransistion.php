<?php

declare(strict_types=1);

namespace Domain\Subscription\Traits;

use Carbon\Carbon;
use Spatie\ModelStates\State;

trait CanTransistion
{
    public static function transitioning(string $subscriptionCode, string $state, Carbon $date = null)
    {
        $subscription = self::firstWhere('subscription_code', $subscriptionCode);

        if ($subscription->state->canTransitionTo($state)) {
            $subscription->state->transitionTo($state);
            is_null($date) ? null : $subscription->update(['cancelled_at' => $date]);
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
     * @return State
     */
    public static function checkState(string $subscriptionCode): State
    {
        return self::firstWhere('subscription_code', $subscriptionCode)->state;
    }
}
