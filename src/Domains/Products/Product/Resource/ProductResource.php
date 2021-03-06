<?php

namespace Domain\Products\Product\Resource;

use Domain\Products\Attributes\Resource\AttributeResource;
use Domain\Products\Skus\Resource\SkuResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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

            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => 'physical',
            'active' => true,
            'featured' => false,
            'images' => $this->whenLoaded('media'),
            'price' => $this->price,
            'sku' => new SkuResource($this->whenLoaded('sku')),
            'properties' => AttributeResource::collection($this->whenLoaded('properties')),
            //$this->getMedia('products')->map(fn ($img) => $img->getUrl('thumb')), // product/detail/thumb

        ];
    }
}
