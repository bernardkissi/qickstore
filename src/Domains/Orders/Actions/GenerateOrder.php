<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Checkouts\RecurringCheckout;
use Domain\Orders\Order;
use Domain\Subscription\ProductSubscription;
use Illuminate\Support\Facades\Log;

class GenerateOrder
{
    public static function execute(array $payload): void
    {
        $planCode = $payload['data']['plan']['plan_code'];
        $customerCode = $payload['data']['customer']['customer_code'];
        $total = $payload['data']['amount'];
        $providerId = $payload['data']['id'];

        $subscription = ProductSubscription::searchSubscription($planCode, $customerCode);

        if ($subscription) {
            $parentOrder = $subscription->order->load(['products', 'orderable']);
            $orderDetails = static::orderData($parentOrder, $total, $providerId, $subscription->id);

            Log::info("Order Details", $orderDetails);

            (new RecurringCheckout($parentOrder['orderable']))->createOrder($orderDetails);
        }
    }

    /**
     * Retriving parent order details
     *
     * @param array $payload
     *
     * @return array
     */
    private static function orderData(Order $order, int $total, int $providerId, int $subscriptionId): array
    {
        $sku = $order['products']->first()->skuable->type;
        $state = $sku === 'digital' ? true : false;

        return [
            'items_count' => 1,
            'shipping_id' => $order['shipping_id'],//$state ? null : $payload['shipping_id'],
            'shipping_service' => $order['shipping_service'], //$state ? null : ,
            'shipping_cost' => 20,
            'payment_gateway' => 'paystack',
            'instructions' => $state ? null : $order['instructions'],
            'total' => $total,
            'address_id' => $order['address_id'],
            'address' => null,
            'product_id' => $order['products']->first()->id,
            'provider_order_id' => $providerId,
            'subscription_id' => $subscriptionId,
        ];
    }
}
