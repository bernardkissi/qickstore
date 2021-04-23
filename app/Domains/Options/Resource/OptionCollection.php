<?php

namespace App\Domains\Options\Resource;

use App\Domains\Options\Resource\OptionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OptionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return OptionResource::collection($this->collection);
    }
}
