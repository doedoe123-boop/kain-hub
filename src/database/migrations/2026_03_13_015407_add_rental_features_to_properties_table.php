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
        Schema::table('properties', function (Blueprint $table) {
            $table->jsonb('direction_steps')->nullable()->after('nearby_places');
            $table->jsonb('house_rules')->nullable()->after('direction_steps');
            $table->jsonb('utility_inclusions')->nullable()->after('house_rules');
            $table->jsonb('safety_features')->nullable()->after('utility_inclusions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'direction_steps',
                'house_rules',
                'utility_inclusions',
                'safety_features',
            ]);
        });
    }
};
