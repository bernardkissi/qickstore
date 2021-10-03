<?php

namespace Database\Factories;

use Domain\Products\Options\Option;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class OptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Option::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElements(['red', 'blue'])[0],
        ];
    }

    /**
    * Assigns a type to the product created
    *
    * @return boolean
    */
    public function canHaveDifferentOptions(string $optionType)
    {
        $arr = $this->generateOptions($optionType);

        return $this->state(new Sequence(
            ['name' => $arr[0]],
            ['name' => $arr[1]],
            ['name' => $arr[2]],
            ['name' => $arr[3]],
            ['name' => $arr[4]],
        ));
    }

    /**
     * Generate options based on types
     *
     * @param string $optionType
     * @return void
     */
    protected function generateOptions(string $optionType)
    {
        if ($optionType === 'color') {
            return ['red','blue','green','yellow','white'];
        }
        if ($optionType === 'size') {
            return ['sm','m','l','xl','xxl'];
        }
        if ($optionType === 'material') {
            return ['cotton','polyester','nylon','silk', 'wool'];
        }
        if ($optionType === 'memory') {
            return ['4GB','8GB','16GB','64GB', '128GB'];
        }
    }
}
