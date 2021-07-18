<?php

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\Facade\Cart;
use App\Domains\Products\Skus\Model\Sku;
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
        Cart::user()->sync();

        return Cart::user()->cartContents()->additional(
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
        return Cart::user()->add($products);
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
        Cart::user()->update($sku->id, $quantity);
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
        Cart::user()->delete($sku->id);
    }

    /**
     * Removes all item from cart
     *
     * @return void
     */
    public function clearCart()
    {
        Cart::user()->clear();
    }
}
