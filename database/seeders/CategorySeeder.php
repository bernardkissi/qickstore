<?php

namespace Database\Seeders;

use App\Domains\Products\Categories\Models\Category;
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
        Category::factory()->count(50)->state(new Sequence(
            ['parent_id' => '1'],
            ['parent_id' => '2'],
            ['parent_id' => '3'],
            ['parent_id' => '4'],
            ['parent_id' => null ],
        ))->create();
    }
}
