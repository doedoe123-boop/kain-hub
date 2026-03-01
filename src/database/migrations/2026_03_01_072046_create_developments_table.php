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
        Schema::create('developments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('developer_name')->nullable();
            $table->string('development_type')->default('condominium');
            $table->string('status')->default('active');

            // Location
            $table->string('address_line')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Details
            $table->integer('total_units')->nullable();
            $table->integer('available_units')->nullable();
            $table->integer('floors')->nullable();
            $table->integer('year_built')->nullable();
            $table->decimal('price_range_min', 15, 2)->nullable();
            $table->decimal('price_range_max', 15, 2)->nullable();

            // Media & features
            $table->jsonb('amenities')->nullable();
            $table->jsonb('images')->nullable();
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
            $table->string('video_url')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['store_id', 'status']);
            $table->index(['city', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};
