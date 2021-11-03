<?php

namespace Domain\Cart\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionCartResource extends JsonResource
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
        $product = $this->product;
        return [

            'name' => $product->name,
            'type' => $product->type,
            'active' => $product->active,
            'subscription' => [
                'name' => $this->plan_name,
                'interval' => $this->interval,
                
            ]

        ];
    }
}
