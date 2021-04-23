<?php

namespace Database\Factories;

use App\Domains\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        return [

            'name' => $product = $this->faker->unique()->name,
            'slug' => Str::slug($product),
            'description' => $this->faker->sentence(5),
            'price' => mt_rand(100, 500)
        ];
    }
}
