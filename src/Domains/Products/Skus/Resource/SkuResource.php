<?php

namespace Domain\Products\Skus\Resource;

use Domain\Products\Product\Resource\ProductResource;
use Domain\Products\Product\Resource\ProductVariationResource;
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
        $resourceType = match ($this->skuable_type) {
            'Product' => ProductResource::class,
            'Variation' => ProductVariationResource::class,
        };

        return [
            'id' => $this->id,
            'price' => $this->price,
            'compare_price' => $this->compare_price,
            'stock' => $this->stockCount->stock,
            'unlimited' => $this->unlimited,
            'in_stock' => $this->inStock(),
            'low_on_stock' => $this->onlowStock(),
            'product' => $resourceType::make($this->whenLoaded('skuable')),
        ];
    }
}
