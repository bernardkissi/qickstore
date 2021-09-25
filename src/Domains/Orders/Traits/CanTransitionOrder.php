<?php

declare(strict_types=1);

namespace Domain\Orders\Traits;

use Domain\Delivery\Traits\CanRankStates;
use Domain\Orders\OrderStatus;

trait CanTransitionOrder
{
    use CanRankStates;

    /**
     * Perform delivery order transition
     *
     * @param string $state
     * @return void
     */
    public function transitionState(string $state): void
    {
        $deliveries = $this->load(['deliveries'])['deliveries'];
        $status = $this->load(['status'])['status'];

        if ($deliveries->count() > 1) {
            $value = $deliveries->map(
                fn ($delivery) => $this->rankState($delivery->state->status())
            )->min();

            $mapState = static::deliveryOrderStateMapping($value);
            static::transition($status, $mapState);
        }

        if ($deliveries->count() <= 1) {
            static::transition($status, $state);
        }
    }

    /**
     * Transition order from one state to another
     *
     * @param OrderStatus $status
     * @param string $state
     * @return void
     */
    private static function transition(OrderStatus $status, string $state): void
    {
        if ($status->state->canTransitionTo($state)) {
            $status->state->transitionTo($state);
            $status->updateHistory($state);
        }
    }

    /**
     * Map delivery status to order status
     *
     * @param integer $value
     * @return void
     */
    private static function deliveryOrderStateMapping(int $value): string
    {
        return match ($value) {
            0 => 'failed',
            1 => 'processing',
            2 => 'processing',
            3 => 'shipped',
            4 => 'shipped',
            5 => 'shipped',
            6 => 'delivered',
            default => 'pending'
        };
    }
}
