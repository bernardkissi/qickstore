<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Order;
use Domain\Orders\OrderStatus;
use Illuminate\Http\JsonResponse;

class OrderManageStates
{
    /**
     * Changes order state
     *
     * @param Order $order
     * @param string $state
     * @return void
     */
    public static function changeState(Order $order, string $state): array|JsonResponse
    {
        $status = $order->status;
        $trans = $order->transition($status, $state);

        if ($trans) {
            return static::formatTimeline($status->updated_from);
        }
        return response()->json(
            ['message' => "The order is already in $state or is not a supported transition"],
            401
        );
    }

    /**
     * Returns all states an order has undergone through
     *
     * @param Order $order
     * @return array
     */
    public static function getTimeline(Order $order): array
    {
        $statuses = $order->status->updated_from;
        return static::formatTimeline($statuses);
    }

    /**
     * Sort the statuses with time updated
     *
     * @param array $updates
     * @return array
     */
    private static function formatTimeline(array $updates): array
    {
        return collect($updates)
            ->sortByDesc('time')
            ->reverse()
            ->all();
    }
}
