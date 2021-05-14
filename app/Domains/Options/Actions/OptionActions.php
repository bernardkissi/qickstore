<?php

declare(strict_types=1);

namespace App\Domains\Options\Actions;

use App\Domains\Options\Models\OptionType;
use Illuminate\Support\Collection;

class OptionActions
{
    /**
     * @var array
     */
    public function __construct(public array $options)
    {
    }

    /**
     *  Stores product options
     *
     * @return Illuminate\Support\Collection
     */
    public function storeOptions(): Collection
    {
        $types = array_keys($this->options);

        return collect($types)->map(function ($type) {
            return OptionType::create(['name' => $type, 'input_type' => 'dropdown']);
        })
        ->map(function ($type) {
            return $type->options()
                ->createMany($this->setOptions($type->name));
        })
        ->collapse()
        ->pluck('id');
    }
    
    /**
     * Prepare product options
     *
     * @param array $arr
     * @param string $key
     * @return array
     */
    private function setOptions(string $key): array
    {
        $options = [];
        foreach ($this->options[$key] as $option) {
            $options[] = ['name' => $option];
        }
        return $options;
    }
}
