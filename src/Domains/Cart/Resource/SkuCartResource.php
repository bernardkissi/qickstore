<?php

namespace Domain\Cart\Resource;

use Cknow\Money\Money;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuCartResource extends JsonResource
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
            'Product' => ProductCartResource::class,
            'Variation' => VariationCartResource::class,
        };

        return [
            'id' => $this->id,
            'order_quantity' => $this->pivot->quantity,
            'price' => $this->price,
            'discount_price' => $this->pivot->discount ? $this->calcDiscountPrice() : null,
            'sku_code' => $this->code,
            'in_stock' => $this->inStock(),
            'quantity_left' => (int) $this->stockCount->stock,
            'type' => $this->skuable_type,
            'item' => $resourceType::make($this->whenLoaded('skuable')),
            'total_price' => Money::parse($this->pivot->discount ? $this->calcDiscountPrice() : $this->price, 'GHS')
                            ->amount()->multiply($this->pivot->quantity)->format(),
        ];
    }


    // private function calcDiscountPrice(): ?int
    // {
    //     $difference = $this->price * ($this->pivot->discount/100);
    //     return $this->price - $difference;
    // }
}
