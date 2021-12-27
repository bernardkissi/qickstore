<?php

declare(strict_types=1);

namespace Domain\Subscription\Actions;

use Domain\Orders\Order;
use Domain\Subscription\Jobs\SubscribeToProductWithProvider;
use Domain\Subscription\ProductSubscription;

class CreateProductSubsctription
{
    public static function execute(array $payload): void
    {
        //TODO: check if the subscription is already created
        $order = Order::find($payload['data']['metadata']['order_id']);
        $product = $order->fetchSubscribedProduct();

        $subscription = ProductSubscription::create([
            'sku_id' => $product->id,
            'order_id' => $payload['data']['metadata']['order_id'],
            'plan_id' => $product->skuable->id,
            'plan_code' => $product->skuable->plan_code,
            'auth_code' => $payload['data']['authorization']['authorization_code'],
            'channel' => $payload['data']['channel'],
            'customer_code' => $payload['data']['customer']['customer_code'],
            'customer_email' => $payload['data']['customer']['email'],
            'start_date' => now(),
        ]);

        SubscribeToProductWithProvider::dispatch($subscription);
    }
}
