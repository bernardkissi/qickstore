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
        return Cart::cartContents()->additional(
            ['meta' => [

                    'isEmpty' => Cart::isEmpty(),
                    'subtotal' => Cart::subTotal(),
                    'delivery_details' => Cart::withDelivery($query)->deliveryDetails(),
                    'delivery_cost' =>Cart::deliveryCost(),
                    'total' =>Cart::total(),
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
