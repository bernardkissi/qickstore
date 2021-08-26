<?php

namespace Domain\Products\Skus\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
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

            'code' => $this->code,
            'stock' => $this->stockCount->stock,
            'unlimited' => $this->unlimited,
            'in_stock' => $this->inStock(),
            'low_on_stock' => $this->onlowStock(),
        ];
    }
}
