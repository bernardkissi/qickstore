<?php

namespace App\Domains\Cart\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationCartResource extends JsonResource
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
            'product' => $this->product->name,
            'variant' => $this->name,
            'identifer' => $this->identifer,
            'properties' => $this->properties,
            'thumbnail' => $this->product->getMedia('products')->map(fn ($img) => $img->getUrl('thumb'))[0]
        ];
    }
}
