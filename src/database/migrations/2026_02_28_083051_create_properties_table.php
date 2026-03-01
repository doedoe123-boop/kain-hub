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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Listing classification
            $table->string('property_type');    // house, condo, lot, etc.
            $table->string('listing_type');     // for_sale, for_rent, for_lease, pre_selling
            $table->string('status')->default('draft');

            // Pricing
            $table->decimal('price', 15, 2);
            $table->string('price_currency', 3)->default('PHP');
            $table->string('price_period')->nullable(); // per_month, per_year (for rent/lease)

            // Property specs — nullable so lots/commercial don't require bedrooms
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->unsignedSmallInteger('garage_spaces')->nullable();
            $table->decimal('floor_area', 10, 2)->nullable();  // sqm
            $table->decimal('lot_area', 10, 2)->nullable();     // sqm
            $table->unsignedSmallInteger('year_built')->nullable();
            $table->unsignedSmallInteger('floors')->nullable();

            // Location
            $table->string('address_line')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Features & media (dynamic — agents add whatever they want)
            $table->jsonb('features')->nullable();    // ["swimming pool", "gated", "corner lot"]
            $table->jsonb('images')->nullable();       // [{"path": "...", "caption": "..."}]
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();

            // SEO & visibility
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes for common queries
            $table->index(['store_id', 'status']);
            $table->index(['property_type', 'listing_type', 'status']);
            $table->index(['city', 'status']);
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
