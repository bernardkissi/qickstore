<?php

namespace Database\Factories;

use App\Domains\Products\Skus\Model\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
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

            'code' => Str::uuid(),
            'price' => 1000

        ];
    }
}
