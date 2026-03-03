<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lunar_orders', function (Blueprint $table): void {
            // PayMongo payment intent ID — stored so we can reconcile webhook events.
            $table->string('payment_intent_id')->nullable()->unique()->after('fingerprint');

            // PayMongo client_key — returned to the frontend SDK to complete the payment form.
            // Stored so the intent endpoint is idempotent (safe to call twice).
            $table->string('payment_client_key')->nullable()->after('payment_intent_id');

            // Mirrors PayMongo's payment intent status ('pending', 'paid', 'failed', 'refunded').
            $table->string('payment_status')->nullable()->after('payment_client_key');

            // Timestamps for key payment lifecycle events.
            $table->timestamp('paid_at')->nullable()->after('placed_at');
            $table->timestamp('cancelled_at')->nullable()->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lunar_orders', function (Blueprint $table): void {
            $table->dropColumn(['payment_intent_id', 'payment_client_key', 'payment_status', 'paid_at', 'cancelled_at']);
        });
    }
};
