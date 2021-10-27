<?php

declare(strict_types=1);

namespace Domain\Orders\Checkouts;

use Domain\Cart\Facade\Cart;
use Domain\Orders\Checkouts\Contract\Checkoutable;
use Domain\Orders\Order;
use Domain\Payments\Facade\Payment;
use Domain\User\User;
use Domain\User\Visitor;

class StandardCheckout implements Checkoutable
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
                'items_count' => $data['items_count'],
                'shipping_id' => $data['shipping']['id'] ?? null,
                'shipping_service' => $data['shipping']['service'] ?? null,
                'shipping_cost' => $data['shipping']['amount'] ?? null,
                'payment_gateway' => $data['gateway'],
                'instructions' => $data['instructions'],
                'coupon_id' => $data['discount']['coupon_id'] ?? null,
                'discount' => $data['discount']['amount'] ?? null,
                'total' => $data['total'],
                'address_id' => $addressId,
            ]
        );
        $order->products()->sync(Cart::products()->toCollect());

        return $order;
    }

    /**
     * Runs payment for the pending order
     *
     * @return string
     */
    public function payOrder(?array $payload): ?array
    {
        return Payment::Charge($payload);
    }
}
