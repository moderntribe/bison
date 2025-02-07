<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles
        $roles = RolesEnum::cases();

        foreach ($roles as $role) {
            $roleContract = Role::findOrCreate($role->value);
            $permissions  = config("roles_permissions.{$role->value}");

            if (! $permissions) {
                continue;
            }

            foreach ($permissions as $permission) {
                $permission = Permission::findOrCreate($permission);
                $roleContract->givePermissionTo($permission);
            }
        }

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
