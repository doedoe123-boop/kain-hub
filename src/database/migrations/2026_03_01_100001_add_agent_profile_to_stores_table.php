<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // ── Agent Profile ──────────────────────────────
            $table->text('agent_bio')->nullable()->after('sector');
            $table->string('agent_photo')->nullable()->after('agent_bio');
            $table->jsonb('agent_certifications')->nullable()->after('agent_photo');
            $table->string('prc_license_number')->nullable()->after('agent_certifications');
            $table->jsonb('agent_specializations')->nullable()->after('prc_license_number');
            $table->jsonb('social_links')->nullable()->after('agent_specializations');

            // ── Mortgage Calculator Defaults ───────────────
            $table->decimal('default_interest_rate', 5, 2)->nullable()->after('social_links');
            $table->integer('default_loan_term_years')->nullable()->after('default_interest_rate');
            $table->decimal('default_down_payment_percent', 5, 2)->nullable()->after('default_loan_term_years');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'agent_bio',
                'agent_photo',
                'agent_certifications',
                'prc_license_number',
                'agent_specializations',
                'social_links',
                'default_interest_rate',
                'default_loan_term_years',
                'default_down_payment_percent',
            ]);
        });
    }
};
