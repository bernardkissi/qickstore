<?php

namespace Domain\Products\Product\Resource;

use Domain\Products\Skus\Resource\SkuResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BundleResource extends JsonResource
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

            'name' => $this->name,
            'active' => $this->is_active ? true : false,
            'type' => 'physical',
            'products' => SkuResource::collection($this->whenLoaded('skus'))

        ];
    }
}
