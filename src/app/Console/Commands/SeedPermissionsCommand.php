<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seed Spatie permissions and assign them to roles.
 *
 * This is idempotent — safe to run multiple times.
 * Existing permissions/roles won't be duplicated.
 */
class SeedPermissionsCommand extends Command
{
    protected $signature = 'permissions:seed';

    protected $description = 'Seed fine-grained permissions and assign to roles';

    /**
     * Permissions grouped by resource.
     *
     * @var array<string, list<string>>
     */
    private const PERMISSIONS = [
        'stores' => ['view', 'create', 'update', 'delete', 'approve', 'suspend'],
        'orders' => ['view', 'create', 'update', 'delete'],
        'payouts' => ['view', 'manage'],
        'users' => ['view', 'manage'],
        'announcements' => ['view', 'create', 'update', 'delete'],
        'legal-pages' => ['view', 'create', 'update', 'delete'],
        'support-tickets' => ['view', 'manage'],
    ];

    public function handle(): int
    {
        $this->info('Seeding permissions...');

        // Create all permissions
        $allPermissions = [];

        foreach (self::PERMISSIONS as $resource => $actions) {
            foreach ($actions as $action) {
                $name = "{$resource}.{$action}";
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
                $allPermissions[] = $name;
                $this->line("  ✓ {$name}");
            }
        }

        $this->newLine();
        $this->info('Assigning permissions to roles...');

        // Admin gets everything
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($allPermissions);
        $this->line('  ✓ admin → all permissions');

        // Store owner gets store-scoped permissions
        $storeOwnerRole = Role::firstOrCreate(['name' => 'store_owner', 'guard_name' => 'web']);
        $storeOwnerRole->syncPermissions([
            'stores.view', 'stores.update',
            'orders.view', 'orders.create', 'orders.update',
            'payouts.view',
        ]);
        $this->line('  ✓ store_owner → store-scoped permissions');

        // Staff gets limited permissions
        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staffRole->syncPermissions([
            'stores.view',
            'orders.view', 'orders.update',
        ]);
        $this->line('  ✓ staff → limited permissions');

        // Customer gets minimal permissions
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $customerRole->syncPermissions([
            'orders.view', 'orders.create',
        ]);
        $this->line('  ✓ customer → customer permissions');

        $this->newLine();
        $this->info('Done! '.count($allPermissions).' permissions seeded across 4 roles.');

        return self::SUCCESS;
    }
}
