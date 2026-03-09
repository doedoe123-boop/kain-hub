<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Backfill placed_at for existing orders so they appear in Lunar's
     * store-owner panel which filters on placed_at by default.
     */
    public function up(): void
    {
        DB::table('lunar_orders')
            ->whereNull('placed_at')
            ->update(['placed_at' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        // Not reversible — placed_at was NULL before, but we don't know which
        // rows were originally NULL vs intentionally set.
    }
};
