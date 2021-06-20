<?php

namespace App\Domains\Cart\Resource;

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
        return [
            'cart' => SkuCartResource::collection($this->whenLoaded('cart')),
        ];
    }
}
