<?php

namespace Database\Factories;

use App\Domains\Categories\Models\Category;
use App\Domains\Categories\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'name' => $name = $this->faker->unique()->word,
           'slug' => Str::slug('_'.$name),
           'category_id' => Category::factory(),
        ];
    }

    public function hasChildren()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => 1,
            ];
        });
    }
}
