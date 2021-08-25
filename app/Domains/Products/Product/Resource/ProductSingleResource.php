<?php

namespace App\Domains\Products\Product\Resource;

use App\Domains\Products\Options\Resource\OptionCollection;
use App\Domains\Products\Product\Resource\ProductVariationResource;

class ProductSingleResource extends ProductResource
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
        return array_merge(
            parent::toArray($request),
            [
                $this->mergeWhen(count($this->variations) > 0, [

                    'product_options' => OptionCollection::collection($this->options->groupBy('types.name')),
                    'product_variations' => ProductVariationResource::collection($this->variations),

                ]),

            ]
        );
    }
}
