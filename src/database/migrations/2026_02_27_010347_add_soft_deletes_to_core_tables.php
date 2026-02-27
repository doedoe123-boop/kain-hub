<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add soft delete columns to core tables: users, stores, orders, payouts.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
