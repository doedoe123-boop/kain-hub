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
        Schema::table('global_seo_settings', function (Blueprint $table) {
            $table->boolean('paypal_checkout_enabled')
                ->default(true)
                ->after('facebook_pixel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_seo_settings', function (Blueprint $table) {
            $table->dropColumn('paypal_checkout_enabled');
        });
    }
};
