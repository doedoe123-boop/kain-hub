<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('open_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_attendees')->nullable();
            $table->boolean('is_virtual')->default(false);
            $table->string('virtual_link')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, ongoing, completed, cancelled
            $table->timestamps();

            $table->index(['store_id', 'event_date']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('open_houses');
    }
};
