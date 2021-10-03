<?php

namespace Database\Factories;

use App\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city' => $this->faker->city,
            'region' => $this->faker->unique()->randomElements(['Ashanti', 'Greater Accra', 'Eastern'])[0],
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'digital' => $this->faker->numberBetween(1000000, 9999999),

            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    /**
    * Set up child child categories
    *
    * @return boolean
    */
    public function canHaveChildCategories()
    {
        return $this->state(new Sequence(
            ['is_default' => true],
            ['is_default' => false],
        ));
    }
}
