<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lunar_orders', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('channel_id')->constrained()->nullOnDelete();
            $table->unsignedInteger('commission_amount')->default(0)->after('total');
            $table->unsignedInteger('store_earning')->default(0)->after('commission_amount');
            $table->unsignedInteger('platform_earning')->default(0)->after('store_earning');

            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lunar_orders', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropIndex(['store_id']);
            $table->dropColumn(['store_id', 'commission_amount', 'store_earning', 'platform_earning']);
        });
    }
};
