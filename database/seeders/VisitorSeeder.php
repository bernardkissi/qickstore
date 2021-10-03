<?php

namespace Database\Seeders;

use Domain\User\Visitor;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visitor::factory()->count(2)->create();
    }
}
