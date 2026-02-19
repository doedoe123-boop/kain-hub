<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LunarSeeder::class);

        $this->seedRolesAndPermissions();

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@marketplace.test',
            'role' => UserRole::Admin,
        ]);
        $admin->assignRole('admin');

        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'role' => UserRole::Customer,
        ]);

        $this->call([
            StoreSeeder::class,
            PayoutSeeder::class,
        ]);

        $this->assignStoreOwnerRoles();
    }

    /**
     * Configure Spatie roles with Lunar permissions.
     */
    private function seedRolesAndPermissions(): void
    {
        $guard = 'web';

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'staff', 'guard_name' => $guard]);
        $storeOwnerRole = Role::firstOrCreate(['name' => 'store_owner', 'guard_name' => $guard]);

        $allPermissions = Permission::where('guard_name', $guard)->get();
        $adminRole->syncPermissions($allPermissions);

        $storeOwnerRole->syncPermissions($allPermissions);
    }

    /**
     * Assign the store_owner Spatie role to all seeded store owners.
     */
    private function assignStoreOwnerRoles(): void
    {
        User::where('role', UserRole::StoreOwner)->each(function (User $user): void {
            if (! $user->hasRole('store_owner')) {
                $user->assignRole('store_owner');
            }
        });
    }
}
