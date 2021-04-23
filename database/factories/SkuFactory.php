<?php

namespace Database\Factories;

use App\Domains\Skus\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;

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

            'code' => mt_rand(100, 999),
            'price' => 1000
           
        ];
    }
}
