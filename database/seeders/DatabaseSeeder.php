<?php

namespace Database\Seeders;

use App\Domains\Categories\Models\Category;
use App\Domains\Categories\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::factory()->count(50)->state(new Sequence(
            ['parent_id' => '1'],
            ['parent_id' => null ],
        )) ->create();
    }
}
