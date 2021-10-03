<?php

namespace Database\Factories;

use Domain\Products\Options\Option;
use Domain\Products\Options\OptionType;
use Domain\Products\Product\Product;
use Domain\Products\Product\ProductVariation;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use function GuzzleHttp\Promise\queue;

class ProductVariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariation::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $color = $this->faker->colorName();
        $size = $this->faker->randomElements(['s', 'm', 'l', 'xl'])[0];

        return [
           'name' => $name = "$color.$size",
           'slug' => Str::slug($name),
           'properties' => json_encode([$color, $size]),
        ];
    }


    /**
    * Configure the model factory.
    *
    * @return $this
    */
    public function configure()
    {
        return $this->afterMaking(function (ProductVariation $variant) {
            //
        })->afterCreating(function (ProductVariation $variant) {
            $variant->sku()->save(Sku::factory()->haslimit()->create(
                [
                    'skuable_id'   => $variant->id,
                    'skuable_type' => ProductVariation::class
                ]
            ));
        });
    }
}
