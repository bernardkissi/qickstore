<?php

namespace App\Domains\Cart\Resource;

use App\Domains\Cart\Resource\ProductCartResource;
use App\Domains\Cart\Resource\VariationCartResource;
use Cknow\Money\Money;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'sku_code' => $this->code,
            'in_stock' => $this->inStock(),
            'type' => $this->skuable_type,
            'item' =>  $resourceType::make($this->whenLoaded('skuable')) ,
            'total_price' => Money::parse($this->price, 'GHS')->amount()->multiply($this->pivot->quantity)->format()
        ];
    }
}
