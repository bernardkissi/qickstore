<?php

namespace Database\Seeders;

use App\Domains\User\User;
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
        User::factory()->count(10)->create();
        //$this->call(CategorySeeder::class);
        // $this->call(OptionTypeSeeder::class);
        //$this->call(ProductSeeder::class);
    }
}
