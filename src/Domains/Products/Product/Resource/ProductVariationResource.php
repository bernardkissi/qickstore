<?php

namespace Domain\Products\Product\Resource;

use App\Domains\Products\Skus\Resource\SkuResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
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
        return [,
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'identifer' => $this->identifer,
            'properties' => $this->properties,
            'order' => $this->order,
            //'sku' => new SkuResource($this->whenLoaded('sku')),
        ];
    }
}
