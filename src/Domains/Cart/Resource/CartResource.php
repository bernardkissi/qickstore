<?php

namespace Domain\Cart\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $cart = SkuCartResource::collection($this->whenLoaded('cart'));
        return [
            'cart_count' => $cart->count(),
            'cart' => $cart,
        ];
    }
}
