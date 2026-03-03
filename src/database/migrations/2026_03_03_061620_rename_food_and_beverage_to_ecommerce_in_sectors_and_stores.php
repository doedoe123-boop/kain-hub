<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('sectors')
            ->where('slug', 'food_and_beverage')
            ->update(['slug' => 'ecommerce', 'name' => 'E-Commerce']);

        DB::table('stores')
            ->where('sector', 'food_and_beverage')
            ->update(['sector' => 'ecommerce']);
    }

    public function down(): void
    {
        DB::table('sectors')
            ->where('slug', 'ecommerce')
            ->update(['slug' => 'food_and_beverage', 'name' => 'Food & Beverage']);

        DB::table('stores')
            ->where('sector', 'ecommerce')
            ->update(['sector' => 'food_and_beverage']);
    }
};
