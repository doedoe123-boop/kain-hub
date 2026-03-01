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
        Schema::create('property_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // logged-in buyer

            // Contact info (guests can inquire without account)
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message')->nullable();

            // Inquiry pipeline
            $table->string('status')->default('new');
            $table->text('agent_notes')->nullable(); // internal notes by agent
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('viewing_date')->nullable();

            $table->string('source')->default('website'); // website, referral, walk-in

            $table->timestamps();

            $table->index(['store_id', 'status']);
            $table->index(['property_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_inquiries');
    }
};
