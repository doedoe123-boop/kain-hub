<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name');                            // "Food & Beverage"
            $table->string('slug')->unique();                  // "food_and_beverage"
            $table->text('description')->nullable();
            $table->string('icon')->default('heroicon-o-building-storefront'); // Heroicon name
            $table->string('color')->default('indigo');        // Tailwind color name
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
