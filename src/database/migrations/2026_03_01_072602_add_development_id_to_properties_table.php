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
            $table->foreignId('development_id')->nullable()->after('store_id')->constrained()->nullOnDelete();
            $table->string('unit_number')->nullable()->after('development_id');
            $table->integer('unit_floor')->nullable()->after('unit_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropConstrainedForeignId('development_id');
            $table->dropColumn(['unit_number', 'unit_floor']);
        });
    }
};
