<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('unique_views')->default(0);
            $table->unsignedInteger('inquiries')->default(0);
            $table->unsignedInteger('phone_clicks')->default(0);
            $table->unsignedInteger('email_clicks')->default(0);
            $table->unsignedInteger('share_clicks')->default(0);
            $table->timestamps();

            $table->unique(['property_id', 'date']);
            $table->index(['store_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_analytics');
    }
};
