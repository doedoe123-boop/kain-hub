<?php

namespace Database\Seeders;

use App\Models\Payout;
use App\Models\Store;
use Illuminate\Database\Seeder;

class PayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::query()->where('status', 'approved')->get();

        foreach ($stores as $store) {
            Payout::factory(2)->create(['store_id' => $store->id]);
        }
    }
}
