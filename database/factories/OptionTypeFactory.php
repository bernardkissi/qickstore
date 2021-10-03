<?php

namespace Database\Factories;

use Domain\Products\Options\Option;
use Domain\Products\Options\OptionType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class OptionTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OptionType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'name' => $this->faker->unique()->randomElements(['color', 'size', 'material', 'memory'])[0],
        ];
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function canHaveDifferentInputTypes()
    {
        return $this->state(new Sequence(
            ['input_type' => 'swatches'],
            ['input_type' => 'radio'],
            ['input_type' => 'checkbox'],
            ['input_type' => 'dropdown'],
        ));
    }


    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (OptionType $type) {
            //
        })->afterCreating(function (OptionType $type) {
            $type->options()->saveMany(
                Option::factory()
                ->count(3)
                ->canHaveDifferentOptions($type->name)
                ->create(['option_type_id' => $type->id])
            );
        });
    }
}
