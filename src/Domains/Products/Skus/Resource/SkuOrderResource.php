<?php

namespace Domain\Products\Skus\Resource;

use Domain\Products\Product\Resource\ProductOrderResource;

class SkuOrderResource extends SkuResource
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
        return array_merge(
            [
                'product' => new ProductOrderResource($this->whenLoaded('skuable')),
            ],
            parent::toArray($request),
        );
    }
}
