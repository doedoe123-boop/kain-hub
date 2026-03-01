<?php

namespace Tests\Browser\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabaseState;

/**
 * Run migrate:fresh before each Dusk test WITHOUT the rollback teardown.
 *
 * Laravel's built-in DatabaseMigrations trait runs migrate:rollback when
 * the test ends. This causes failures on PostgreSQL when Spatie and other
 * third-party migrations cannot cleanly reverse (e.g. column type casts).
 *
 * Because migrate:fresh drops everything at the start of the next test
 * anyway, the rollback is unnecessary for Dusk.
 */
trait MigratesDuskDatabase
{
    public function runDatabaseMigrations(): void
    {
        $this->artisan('migrate:fresh', $this->migrateFreshUsing());

        RefreshDatabaseState::$migrated = true;

        // No beforeApplicationDestroyed rollback — migrate:fresh handles cleanup.
    }

    /**
     * The parameters that should be used when running "migrate:fresh".
     *
     * @return array<string, mixed>
     */
    protected function migrateFreshUsing(): array
    {
        return [
            '--drop-views' => false,
            '--drop-types' => false,
            '--seed' => false,
        ];
    }
}
