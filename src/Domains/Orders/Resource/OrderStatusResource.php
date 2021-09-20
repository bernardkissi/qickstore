<?php

namespace Domain\Orders\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusResource extends JsonResource
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
            'status' => $this->state,
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
