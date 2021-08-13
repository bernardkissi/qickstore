<?php

namespace App\Domains\Delivery\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingProviderResource extends JsonResource
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
            'price' => $this->price,
            'constraints' => $this->constraints,
        ];
    }
}
