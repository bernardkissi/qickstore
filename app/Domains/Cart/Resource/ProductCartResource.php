<?php

namespace App\Domains\Cart\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCartResource extends JsonResource
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
            'type' => 'physical',
            'active' => true,
            'thumbnail' => $this->getMedia('products')->map(fn ($img) => $img->getUrl('thumb')[0]),
        ];
    }
}
