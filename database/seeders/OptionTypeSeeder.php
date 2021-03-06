<?php

namespace Database\Seeders;

use Domain\Products\Options\OptionType;
use Illuminate\Database\Seeder;

class OptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OptionType::factory()
            ->count(3)
            ->canHaveDifferentInputTypes()
            ->create();
    }
}
