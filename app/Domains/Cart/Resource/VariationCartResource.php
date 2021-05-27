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
            'product' => $this->product->name,
            'id' => $this->id,
            'name' => $this->name,
            'identifer' => $this->identifer,
            'properties' => $this->properties,
        ];
    }
}
