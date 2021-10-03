<?php

namespace Database\Factories;

use Domain\Products\Product\Product;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = mt_rand(100, 500);
        return [

            'name' => $product = $this->faker->unique()->name(),
            'slug' => Str::slug($product),
            'description' => $this->faker->sentence(5),
            'barcode' => $this->faker->numberBetween(1000000, 9999999),
        ];
    }

    /**
     * Assigns a type to the product created
     *
     * @return boolean
     */
    public function canBeDifferentProductTypes()
    {
        return $this->state(new Sequence(
            ['type' => 'digital'],
            ['type' => 'physical'],
            ['type' => 'tickets']
        ));
    }

    /**
     * Schedules product availability.
     *
     * @return void
     */
    public function canScheduledAvailability()
    {
        return $this->state(new Sequence(
            ['is_scheduled_at' => now()->addDays(1)],
            ['is_scheduled_at' => now()->addDays(3)],
            ['is_scheduled_at' => null]
        ));
    }

    /**
     * Can be made available or unavailable.
     *
     * @return boolean
     */
    public function canBeAvailableAndUnavailable()
    {
        return $this->state(new Sequence(
            ['is_active' => true],
            ['is_active' => false],
        ));
    }

    /**
     * Can be made available or unavailable.
     *
     * @return boolean
     */
    public function canBelongToManyCategories()
    {
        return $this->state(new Sequence(
            ['category_id' => 1],
            ['category_id' => 2],
            ['category_id' => 3],
            ['category_id' => null]
        ));
    }

    /**
     * Switch the visibility of the product.
     *
     * @return void
     */
    public function isNotAvailable()
    {
        return $this->state(function (array $attributes) {
            return ['is_active' => false];
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Product $product) {
            //
        })->afterCreating(function (Product $product) {
            $product->sku()->save(Sku::factory()->haslimit()->create(
                [
                    'skuable_id' => $product->id,
                    'skuable_type' => Product::class
                ]
            ));
        });
    }
}
