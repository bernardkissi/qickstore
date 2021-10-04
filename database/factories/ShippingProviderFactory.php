<?php

namespace Database\Factories;

use Domain\Delivery\ShippingProvider;
use Domain\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

class ShippingProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->unique()->company,
            'slug' => Str::slug($name),
            'type' => $this->faker->unique()->randomElements(['DHL', 'Swoove', 'Custom'])[0],
            'description' => $this->faker->sentence(5),
            'price' => $this->faker->numberBetween(100, 1000),
        ];
    }

    /**
     * Set shipping service to active or unactive
     *
     * @return boolean
     */
    public function canBeEnabledOrDisabled()
    {
        return $this->state(new Sequence(
            ['is_enabled' => true],
            ['is_enabled' => false],
        ));
    }


    public function canBeGlobalOrCustom()
    {
        return $this->state(new Sequence(
            ['user_id' => User::factory()->create()->id],
            ['user_id' => null],
        ));
    }
}
