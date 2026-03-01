<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Floor plan images with labels: [{url, label, floor_number}]
            $table->jsonb('floor_plans')->nullable()->after('images');

            // Documents (brochures, price lists, PDFs): [{url, name, type, size_kb}]
            $table->jsonb('documents')->nullable()->after('floor_plans');

            // Neighborhood / nearby places: [{name, type, distance, distance_unit}]
            $table->jsonb('nearby_places')->nullable()->after('documents');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['floor_plans', 'documents', 'nearby_places']);
        });
    }
};
