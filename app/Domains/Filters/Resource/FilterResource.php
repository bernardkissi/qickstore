<?php

namespace App\Domains\Filters\Resource;

use App\Domains\Filters\Models\Filter;
use App\Domains\Properties\Models\Property;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
{


    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = Filter::class;


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
