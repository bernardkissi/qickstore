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
        $shipping = $data['shipping_id'] !== null ?
        Cart::withShipping($data['shipping_id']) : Cart::withoutShipping();

        $addressId = $this->customer->createAddress($data['address'], $data['address_id'])->id;

        $order = $this->customer->orders()->create(
            [
                'total' => Cart::total()->getAmount(),
                'items_count' => Cart::countItems(),
                'shipping_id' => $shipping?->shippingDetails()->id,
                'shipping_service' => $shipping?->shippingDetails()->type,
                'shipping_cost' => Cart::shippingCost()->getAmount(),
                'payment_gateway' => $data['gateway'],
                'instructions' => $data['instructions'],
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
