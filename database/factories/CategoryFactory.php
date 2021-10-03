<?php

namespace Database\Factories;

use Domain\Products\Categories\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->unique()->word,
            'slug' => Str::slug('_'.$name)
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
            ['parent_id' => '1'],
            ['parent_id' => '2'],
            ['parent_id' => '3'],
            ['parent_id' => '4'],
            ['parent_id' => null ],
        ));
    }
}
