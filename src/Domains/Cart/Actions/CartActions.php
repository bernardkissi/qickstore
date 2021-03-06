<?php

namespace Domain\Cart\Actions;

use Domain\Cart\Facade\Cart;
use Domain\Products\Skus\Sku;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartActions
{
    /**
     * Return customer cart items
     *
     * @param Request $request
     *
     * @return JsonResource
     */
    public function getCart(array $query): JsonResource
    {
        $shippingId = $query['shipping_id'] ?? null;

        return Cart::cartContents()->additional(
            ['meta' => [
                'isEmpty' => Cart::isEmpty(),
                'subtotal' => $subtotal = Cart::withShipping($shippingId)->subTotal(),
                'discount' => [
                    'coupon_id' => Cart::setCoupon()->getCoupon()->id ?? null,
                    'value' => Cart::discount($subtotal),
                ],
                'shipping' => [
                    'id' => Cart::shippingDetails()->id,
                    'service' => Cart::shippingDetails()->type,
                    'value' => Cart::shippingCost(),
                ],
                'total' => Cart::total(),
                'changed' => Cart::hasChanged(),
            ],
            ]
        );
    }

    /**
     * Add products to cart
     *
     * @param array $request
     *
     * @return void
     */
    public function addToCart(array $products)
    {
        return Cart::add($products);
    }

    /**
     * Update items in users/visitors cart
     *
     * @param Sku $sku
     * @param int $quantity
     *
     * @return void
     */
    public function updateItem(Sku $sku, int $quantity): void
    {
        Cart::update($sku->id, $quantity);
    }

    /**
     * Remove a product from the cart
     *
     * @param Sku $sku
     *
     * @return void
     */
    public function deleteItem(Sku $sku): void
    {
        Cart::delete($sku->id);
    }

    /**
     * Removes all item from cart
     *
     * @return void
     */
    public function clearCart()
    {
        Cart::clear();
    }
}
