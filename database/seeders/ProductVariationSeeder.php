<?php

namespace Database\Seeders;

use Domain\Products\Options\OptionType;
use Domain\Products\Product\Product;
use Domain\Products\Product\ProductVariation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = OptionType::factory()->canHaveDifferentInputTypes()->count(2)->create();
        $options = $types->map(fn ($type) => $type->options);
        $values = $options->flatten()->toArray();

        $product = Product::factory()
                    ->canBeDifferentProductTypes()
                    ->canBeAvailableAndUnavailable()
                    ->canScheduledAvailability()
                    ->hasAttached($options, [], 'options')
                    ->create();

        ProductVariation::factory()
            ->for($product)
            ->create([
                'name' => $name = $values[0]['name'].$values[3]['name'],
                'slug' => Str::slug($name),
                'properties' => json_encode([$values[0]['name'], $values[3]['name']]),
            ]);
    }
}
