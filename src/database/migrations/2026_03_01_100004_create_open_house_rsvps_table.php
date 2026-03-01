<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('open_house_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('open_house_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('confirmed'); // confirmed, cancelled, attended, no_show
            $table->timestamps();

            $table->index(['open_house_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('open_house_rsvps');
    }
};
