<?php

namespace Database\Factories;

use Domain\Products\Product\Product;
use Domain\Products\Skus\Sku;
use Domain\Products\Stocks\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

class SkuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sku::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'skuable_id' => Product::factory(),
            'skuable_type' => function (array $attributes) {
                return Product::find($attributes['skuable_id'])->type;
            },
            'price' => $price = $this->faker->numberBetween(100, 1000),
            'compare_price' => $price - 25,
        ];
    }

    /**
     * Defines the model has limited stock or not
     *
     * @return void
     */
    public function haslimit()
    {
        return $this->state(new Sequence(
            ['unlimited' => true],
            ['umlimited' => false],
        ));
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Sku $sku) {
            //
        })->afterCreating(function (Sku $sku) {
            $sku->stocks()->save(Stock::factory()->create(['sku_id' => $sku->id]));
        });
    }
}
