<?php

namespace Database\Seeders;

use Domain\Products\Categories\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(50)
            ->canHaveChildCategories()
            ->create();
    }
}
