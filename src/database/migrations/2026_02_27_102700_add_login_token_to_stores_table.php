<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add a unique login_token to each store.
 *
 * This token is embedded in the store's subdomain login URL so each
 * store owner has a unique, non-guessable access point. The token
 * is generated when the admin approves the store.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('login_token', 64)->nullable()->unique()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('login_token');
        });
    }
};
