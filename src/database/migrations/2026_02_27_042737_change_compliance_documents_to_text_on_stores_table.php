<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('UPDATE stores SET compliance_documents = NULL WHERE compliance_documents IS NOT NULL');
            DB::statement('ALTER TABLE stores ALTER COLUMN compliance_documents TYPE jsonb USING compliance_documents::jsonb');

            return;
        }

        Schema::table('stores', function (Blueprint $table) {
            $table->jsonb('compliance_documents')->nullable()->change();
        });
    }
};
