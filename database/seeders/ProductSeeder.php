<?php

namespace Database\Seeders;

use App\Domains\Products\Product\Models\Product;
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
        Product::factory()->count(100)->hasSku()->create();
    }
}
