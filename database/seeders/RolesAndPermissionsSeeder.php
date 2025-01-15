<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear cache for roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view users',
            'edit users',
            'delete users',
            'view orders',
            'manage orders',
            'view products',
            'manage products',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $clientRole = Role::firstOrCreate(['name' => 'Client']);

        // Assign permissions to Admin role
        $adminRole->syncPermissions($permissions);

        // Assign basic permissions to Client role
        $clientRole->syncPermissions(['view products', 'view orders']);

        // Create admin user and assign Admin role
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Change email if necessary
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), // Change password if necessary
            ]
        );
        $admin->assignRole($adminRole);

        // Create client user and assign Client role
        $client = User::firstOrCreate(
            ['email' => 'client@example.com'], // Change email if necessary
            [
                'name' => 'Client User',
                'password' => bcrypt('password'), // Change password if necessary
            ]
        );
        $client->assignRole($clientRole);

        // Output to console
        $this->command->info('Roles, permissions, and default users seeded successfully!');
    }
}
