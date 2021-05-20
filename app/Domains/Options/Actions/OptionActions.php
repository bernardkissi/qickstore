<?php

declare(strict_types=1);

namespace App\Domains\Options\Actions;

use App\Domains\Options\Models\Option;
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
       
        $collection = collect($types)->map(function ($type) {
            if (!is_null($this->typeExist($type))) {
                return $this->typeExist($type);
            }
            return OptionType::create(['name' => $type, 'input_type' => 'dropdown']);
        });

        return $this->createOptions($collection);
    }
    

    /**
     * Storing options
     *
     * @param Collection $types
     * @return Collection
     */
    private function createOptions(Collection $types): Collection
    {
        return $types->map(function ($type) {
            return collect($this->options[$type->name])->map(function ($key) use ($type) {
                if ($type->options->contains('name', $key)) {
                    return $type->options->filter(fn ($option) => $option->name === $key)->pluck('id');
                }
                return $type->options()->createMany($this->setOptions($type->name))->pluck('id');
            });
        })->flatten();
    }

    /**
     * Prepare product options
     *
     * @param array $arr
     * @param string $key
     * @return array
     */
    private function setOptions(string $key): bool|array
    {
        $options = [];
        foreach ($this->options[$key] as $option) {
            if (!$this->optionExist($option, $key)) {
                $options[] = ['name' => $option];
            }
            continue;
        }
        return $options;
    }


    /**
     *  Checks if option type exit
     *
     * @param string $type
     * @return OptionType
     */
    private function typeExist(string $type): ?OptionType
    {
        return OptionType::where('name', $type)->first();
    }

    /**
     * Check if options exist
     *
     * @param string $option
     * @param string $type
     * @return boolean|null
     */
    private function optionExist(string $option, string $type): null|bool
    {
        $types= Option::where('name', $option)
        ->first()
        ?->types()
        ->pluck('name');

        return $types?->contains($type);
    }
}
