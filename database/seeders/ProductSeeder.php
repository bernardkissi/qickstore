<?php

namespace Database\Seeders;

use Domain\Products\Product\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(10)
            ->canBeDifferentProductTypes()
            ->canBeAvailableAndUnavailable()
            ->canScheduledAvailability()
            ->canBelongToManyCategories()
            ->create();
    }
}
