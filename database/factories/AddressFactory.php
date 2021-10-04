<?php

namespace Database\Factories;

use Domain\User\Address\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->randomElements(['Ashanti', 'Greater Accra', 'Eastern'])[0],
            'country' => $this->faker->country,
            'digital_address' => $this->faker->numberBetween(1000000, 9999999),

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
    public function canBeDefault()
    {
        return $this->state(new Sequence(
            ['is_default' => true],
            ['is_default' => false],
        ));
    }
}
