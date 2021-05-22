<?php

namespace App\Domains\Products\Attributes\Resource;

use App\Domains\Products\Attributes\Models\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = Attribute::class;


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
            'property_name' => $this->property_name,
            'property_value' => $this->property_value
        ];
    }
}
