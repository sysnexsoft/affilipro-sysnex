<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission List
        $permissions = [
            'dashboard',
            'role.permission', 'role.permission.create', 'role.permission.store', 'role.permission.edit', 'role.permission.update', 'role.permission.delete',
            'profile',
            'setting', 'reset.password',
            'user.list', 'user.store','user.update','user.delete',
            'currency.list', 'currency.store','currency.update','currency.delete',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Assign All Permissions to Admin
        $superAdminRole->syncPermissions(Permission::all());

        $user = \App\Models\User::find(1);
        if ($user && !$user->hasRole('super-admin')) {
            $user->assignRole($superAdminRole);
        }

        echo "Permissions & Roles seeded successfully\n";
    }
}
