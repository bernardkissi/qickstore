<?php

namespace App\Domains\Products\Resource;

use App\Domains\Products\Resource\VariationResource;
use App\Domains\Properties\Resource\PropertyResource;
use App\Domains\Skus\Resource\SkuResource;
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
    
            // $this->mergeWhen(count($this->variations) <= 0, [
                 'price' => $this->price,
                 'sku' =>  new SkuResource($this->whenLoaded('sku')),
                 'properties' => PropertyResource::collection($this->whenLoaded('properties'))
            // ])
        ];
    }
}
