<?php

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\Services\Cart;
use App\Domains\User\User;
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
}
