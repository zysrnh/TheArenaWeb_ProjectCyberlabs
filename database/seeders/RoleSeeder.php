<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat semua permissions terlebih dahulu untuk guard 'web'
        $permissions = [
            // Registration permissions
            'view_any_registration',
            'view_registration',
            'create_registration',
            'update_registration',
            'delete_registration',
            'delete_any_registration',
            'force_delete_registration',
            'force_delete_any_registration',
            'restore_registration',
            'restore_any_registration',
            'replicate_registration',
            'reorder_registration',
            
            // User permissions
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'restore_user',
            'restore_any_user',
            'replicate_user',
            'reorder_user',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $webAdminRole = Role::firstOrCreate(['name' => 'web_admin', 'guard_name' => 'web']);
        $adminViewRole = Role::firstOrCreate(['name' => 'admin_view', 'guard_name' => 'web']);
        $adminEditorRole = Role::firstOrCreate(['name' => 'admin_editor', 'guard_name' => 'web']);

        // Super Admin gets all permissions
        $superAdminRole->syncPermissions(Permission::all());

        // Admin View permissions
        $adminViewRole->syncPermissions([
            'view_any_registration',
            'view_registration',
        ]);

        // Admin Editor permissions
        $adminEditorRole->syncPermissions([
            'view_any_registration',
            'view_registration',
            'create_registration',
            'update_registration',
        ]);

        // Web Admin permissions
        $webAdminRole->syncPermissions([
            'view_any_registration',
            'view_registration',
            'create_registration',
            'update_registration',
            'delete_registration',
            'delete_any_registration',
            'force_delete_registration',
            'force_delete_any_registration',
            'restore_registration',
            'restore_any_registration',
            'replicate_registration',
            'reorder_registration',
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'restore_user',
            'restore_any_user',
            'replicate_user',
            'reorder_user',
        ]);
    }
}