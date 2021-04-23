<?php

namespace Database\Seeders;

use App\Domains\Products\Models\Product;
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
        foreach(let $i=0; $i < 1000; $i++){
        	 
        }
        Product::factory()->hasSku()->create();
    }
}
