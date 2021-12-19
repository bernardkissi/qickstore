<?php

declare(strict_types=1);

namespace Domain\Orders\Checkouts;

use Domain\Cart\Facade\Cart;
use Domain\Orders\Checkouts\Contract\Checkoutable;
use Domain\Orders\Order;
use Domain\Payments\Facade\Payment;
use Domain\User\User;
use Domain\User\Visitor;

class RecurringCheckout implements Checkoutable
{
    /**
     * Class constructor
     *
     * @param mixed $customer
     */
    public function __construct(public User | Visitor $customer)
    {
    }

    public function createOrder(array $data): Order
    {
        $addressId = $this->customer->createAddress($data['address'], $data['address_id'])->id;

        $order = $this->customer->orders()->create(
            [
                'items_count' => $data['items_count'] ?? 1,
                'shipping_id' => $data['shipping_id'] ?? null,
                'shipping_service' => $data['shipping_service'] ?? null,
                'shipping_cost' => $data['shipping_amount']?? null,
                'payment_gateway' => $data['gateway'],
                'instructions' => $data['instructions'],
                'total' => $data['total'],
                'address_id' => $addressId,
                'provider_order_id' => $data['provider_id']
            ]
        );
        $order->products()->sync([$data['product_id'] => ['quantity' => 1]]);

        return $order;
    }
}
