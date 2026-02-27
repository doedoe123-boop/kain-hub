<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Encrypt existing plaintext sensitive fields in the stores table.
 *
 * Fields: id_number, business_permit, compliance_documents
 *
 * Also converts the column types to TEXT to accommodate encrypted
 * payloads which are significantly longer than the original values.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Widen columns to TEXT so encrypted payloads fit
        Schema::table('stores', function (Blueprint $table) {
            $table->text('id_number')->nullable()->change();
            $table->text('business_permit')->nullable()->change();
        });

        // Step 2: Encrypt existing plaintext values
        DB::table('stores')
            ->whereNotNull('id_number')
            ->orWhereNotNull('business_permit')
            ->orWhereNotNull('compliance_documents')
            ->orderBy('id')
            ->each(function ($store) {
                $updates = [];

                // Encrypt id_number if it's not already encrypted
                if ($store->id_number) {
                    if (! $this->isEncrypted($store->id_number)) {
                        $updates['id_number'] = Crypt::encryptString($store->id_number);
                    }
                }

                // Encrypt business_permit if it's not already encrypted
                if ($store->business_permit) {
                    if (! $this->isEncrypted($store->business_permit)) {
                        $updates['business_permit'] = Crypt::encryptString($store->business_permit);
                    }
                }

                // Encrypt compliance_documents if it's not already encrypted
                if ($store->compliance_documents) {
                    if (! $this->isEncrypted($store->compliance_documents)) {
                        $updates['compliance_documents'] = Crypt::encrypt(json_decode($store->compliance_documents, true));
                    }
                }

                if (! empty($updates)) {
                    DB::table('stores')
                        ->where('id', $store->id)
                        ->update($updates);
                }
            });
    }

    public function down(): void
    {
        // Decrypt all values back to plaintext
        DB::table('stores')
            ->whereNotNull('id_number')
            ->orWhereNotNull('business_permit')
            ->orWhereNotNull('compliance_documents')
            ->orderBy('id')
            ->each(function ($store) {
                $updates = [];

                if ($store->id_number) {
                    try {
                        $updates['id_number'] = Crypt::decryptString($store->id_number);
                    } catch (\Exception) {
                        // Already plaintext
                    }
                }

                if ($store->business_permit) {
                    try {
                        $updates['business_permit'] = Crypt::decryptString($store->business_permit);
                    } catch (\Exception) {
                        // Already plaintext
                    }
                }

                if ($store->compliance_documents) {
                    try {
                        $updates['compliance_documents'] = json_encode(Crypt::decrypt($store->compliance_documents));
                    } catch (\Exception) {
                        // Already plaintext
                    }
                }

                if (! empty($updates)) {
                    DB::table('stores')
                        ->where('id', $store->id)
                        ->update($updates);
                }
            });

        // Revert column types
        Schema::table('stores', function (Blueprint $table) {
            $table->string('id_number', 255)->nullable()->change();
            $table->string('business_permit', 255)->nullable()->change();
        });
    }

    /**
     * Check if a string looks like it's already encrypted by Laravel.
     */
    private function isEncrypted(string $value): bool
    {
        // Laravel encrypted values are base64-encoded JSON with iv, value, mac keys
        $decoded = base64_decode($value, true);

        if ($decoded === false) {
            return false;
        }

        $json = json_decode($decoded, true);

        return is_array($json) && isset($json['iv'], $json['value'], $json['mac']);
    }
};
