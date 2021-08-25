<?php

namespace App\Domains\Orders\Resource;

use App\Domains\Products\Skus\Resource\SkuOrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'service' => $this->service,
            'subtotal' => $this->subtotal,
            'estimate' => $this->estimate_id,
            'details' => $this->delivery_details,
            'instructions' => $this->instructions,
            'products' => SkuOrderResource::collection($this->whenLoaded('products')),
        ];
    }
}
