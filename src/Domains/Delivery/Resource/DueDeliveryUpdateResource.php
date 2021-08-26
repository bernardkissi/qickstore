<?php

namespace Domain\Delivery\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class DueDeliveryUpdateResource extends JsonResource
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
            'service' => $this->service,
            'delivery_code' => $this->delivery_code,
            'order' => $this->order->id,
            'vendor' => '054306709'
        ];
    }
}
