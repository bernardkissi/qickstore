<?php

declare(strict_types=1);

namespace App\Domains\Orders\Traits;

use App\Domains\Delivery\Model\Delivery;
use App\Domains\Delivery\Traits\CanRankStates;

trait HandlesMultipleDeliveryOrderTransition
{
    use CanRankStates;

    /**
     * Checks if a multiple delivery order can be transitioned to the next state.
     *
     * @param Delivery $currentDelivery
     * @return boolean
     */
    public function transitionOrderState(Delivery $currentDelivery): bool
    {
        $others =  $this->deliveries->reject(fn ($delivery) => $delivery->id === $currentDelivery->id);
        if ($this->rankState($currentDelivery->state->status()) <= $this->rankState($others->first()->state->status())) {
            return true;
        }
        return false;
    }
}
