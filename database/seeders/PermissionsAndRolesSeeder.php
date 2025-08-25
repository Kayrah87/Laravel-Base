<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Permission management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            
            // Settings management
            'view settings',
            'edit settings',
            
            // Media management
            'view media',
            'upload media',
            'delete media',
            
            // Activity logs
            'view activity logs',
            'delete activity logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view roles',
            'view permissions',
            'view settings', 'edit settings',
            'view media', 'upload media', 'delete media',
            'view activity logs',
        ]);

        $moderatorRole = Role::create(['name' => 'Moderator']);
        $moderatorRole->givePermissionTo([
            'view users',
            'view media', 'upload media',
            'view activity logs',
        ]);

        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo([
            'view media', 'upload media',
        ]);

        // Create demo users with roles
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        $superAdmin->assignRole($superAdminRole);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole($adminRole);

        $moderator = User::factory()->create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
        ]);
        $moderator->assignRole($moderatorRole);

        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
        ]);
        $user->assignRole($userRole);

        $this->command->info('Created permissions, roles, and demo users successfully!');
    }
}
