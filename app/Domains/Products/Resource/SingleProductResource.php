<?php

namespace App\Domains\Products\Resource;

use App\Domains\Options\Resource\OptionCollection;
use App\Domains\Products\Resource\ProductResource;
use App\Domains\Products\Resource\VariationResource;
use App\Domains\Skus\Resource\SkuResource;

class SingleProductResource extends ProductResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
               $this->mergeWhen(count($this->variations) > 0, [

                 'product_options' => OptionCollection::collection($this->options->groupBy('types.name')),
                 'product_variations' => VariationResource::collection($this->variations)

               ])
               
            ]
        );
    }
}
