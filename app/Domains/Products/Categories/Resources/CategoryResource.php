<?php

declare(strict_types=1);

namespace App\Domains\Products\Categories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [

            'name' => $this->name,
            'slug' => $this->slug,
            'subcategories' => CategoryResource::collection($this->whenLoaded('subcategories')),
        ];
    }
}
