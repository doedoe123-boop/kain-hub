<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sector_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained()->cascadeOnDelete();
            $table->string('key');              // "dti_sec_registration" — used as array key in uploads
            $table->string('label');            // "DTI / SEC Registration"
            $table->text('description')->nullable();
            $table->boolean('is_required')->default(true);
            $table->string('mimes')->default('pdf,jpg,jpeg,png'); // accepted MIME extensions
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['sector_id', 'key']); // one doc per key per sector
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sector_documents');
    }
};
