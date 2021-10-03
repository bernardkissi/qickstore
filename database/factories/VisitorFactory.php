<?php

namespace Database\Factories;

use Domain\User\Address\Address;
use Domain\User\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip_address' => $this->faker->unique()->ipv4,
            'identifier' => $this->faker->uuid,
            'user_agent' => $this->faker->userAgent,
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->email,
        ];
    }

    /**
    * Configure the model factory.
    *
    * @return $this
    */
    public function configure()
    {
        return $this->afterMaking(function (Visitor $visitor) {
            //
        })->afterCreating(function (Visitor $visitor) {
            $visitor->addresses()->save(Address::factory()->canBeDefault()->create(
                [
                    'addressable_id' => $visitor->id,
                    'addressable_type' => Visitor::class
                ]
            ));
        });
    }
}
