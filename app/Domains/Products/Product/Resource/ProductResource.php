<?php

namespace App\Domains\Products\Product\Resource;

use App\Domains\Products\Attributes\Resource\AttributeResource;
use App\Domains\Products\Skus\Resource\SkuResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description'=> $this->description,
            'type' => 'physical',
            'active' => true,
            'featured' => false,
            'images' => $this->getMedia('products')->map(fn ($img) => $img->getUrl('thumb')), // product/detail/thumb
            'price' => $this->price,
            'sku' =>  new SkuResource($this->whenLoaded('sku')),
            'properties' => AttributeResource::collection($this->whenLoaded('properties'))
            
        ];
    }
}
