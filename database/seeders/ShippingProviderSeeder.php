<?php

namespace Database\Seeders;

use Domain\Delivery\ShippingProvider;
use Illuminate\Database\Seeder;

class ShippingProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingProvider::factory()
            ->count(3)
            ->canBeEnabledOrDisabled()
            ->create();
    }
}
