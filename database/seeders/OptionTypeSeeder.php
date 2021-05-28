<?php

namespace Database\Seeders;

use App\Domains\Products\Options\Models\OptionType;
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
        OptionType::factory()->count(10)->create();
    }
}
