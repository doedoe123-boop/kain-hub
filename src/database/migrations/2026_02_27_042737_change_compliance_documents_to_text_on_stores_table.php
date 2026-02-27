<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Change compliance_documents from jsonb to text so it can store
     * Laravel's encrypted:array cast output (an encrypted string, not JSON).
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->text('compliance_documents')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->jsonb('compliance_documents')->nullable()->change();
        });
    }
};
