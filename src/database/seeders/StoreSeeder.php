<?php

namespace Database\Seeders;

use App\IndustrySector;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dedicated real-estate store — PropertyListingSeeder depends on this slug.
        Store::factory()
            ->sector(IndustrySector::RealEstate)
            ->create(['slug' => 'realty-hub']);

        Store::factory(5)->create();
        Store::factory(2)->pending()->create();
    }
}
