<?php

namespace App\Domains\Skus\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
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

            'code' => $this->code,
            'stock' => $this->stockCount->stock
        ];
    }
}
