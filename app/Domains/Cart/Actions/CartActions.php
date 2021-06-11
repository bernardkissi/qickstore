<?php

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\Services\Cart;
use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartActions
{
    public function __construct(public Cart $cart)
    {
    }


    /**
     * Return customer cart items
     *
     * @param Request $request
     * @return JsonResource
     */
    public function getCart(Request $request): JsonResource
    {
        $this->cart->sync();

        return $this->cart->cartContents()->additional(
            ['meta' => [

                'isEmpty' => $this->cart->isEmpty(),
                'subtotal' => $this->cart->subTotal(),
                'delivery_details' => $this->cart->withDelivery($request->query())->deliveryDetails(),
                'delivery_cost' => $this->cart->deliveryCost(),
                'total' => $this->cart->total(),
                'changed' => $this->cart->hasChanged()
            ]]
        );
    }

    /**
     * Add products to cart
     *
     * @param array $request
     * @return void
     */
    public function addToCart(array $products)
    {
        return $this->cart->add($products);
    }

    /**
     * Update items in users/visitors cart
     *
     * @param Sku $sku
     * @param integer $quantity
     * @return void
     */
    public function updateItem(Sku $sku, int $quantity): void
    {
        $this->cart->update($sku->id, $quantity);
    }

    /**
     * Remove a product from the cart
     *
     * @param Sku $sku
     * @return void
     */
    public function deleteItem(Sku $sku): void
    {
        $this->cart->delete($sku->id);
    }

    /**
     * Removes all item from cart
     *
     * @return void
     */
    public function clearCart()
    {
        $this->cart->clear();
    }
}
