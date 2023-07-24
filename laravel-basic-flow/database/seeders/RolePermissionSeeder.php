<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        // DB::table('model_has_roles')->truncate();
        // DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            [
                'name' => 'create',
                'description' => 'The user can create organization',
                'group' => 'organization',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'edit',
                'description' => 'The user can edit organization',
                'group' => 'organization',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'view',
                'description' => 'The user can view organization',
                'group' => 'organization',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'delete',
                'description' => 'The user can delete organization',
                'group' => 'organization',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'upgrade',
                'description' => 'The user can upgrade organization plan',
                'group' => 'organization',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'create',
                'description' => 'The user can create subsidiary',
                'group' => 'subsidiary',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'edit',
                'description' => 'The user can edit subsidiary',
                'group' => 'subsidiary',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'view',
                'description' => 'The user can view subsidiary',
                'group' => 'subsidiary',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'delete',
                'description' => 'The user can delete subsidiary',
                'group' => 'subsidiary',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'create',
                'description' => 'The user can create shared service',
                'group' => 'shared service',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'edit',
                'description' => 'The user can edit shared service',
                'group' => 'shared service',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'view',
                'description' => 'The user can view shared service',
                'group' => 'shared service',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'delete',
                'description' => 'The user can delete shared service',
                'group' => 'shared service',
                'can_access' => ['creator administrator']
            ],
            [
                'name' => 'create',
                'description' => 'The user can create branch',
                'group' => 'branch',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'edit',
                'description' => 'The user can edit branch',
                'group' => 'branch',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'view',
                'description' => 'The user can view branch',
                'group' => 'branch',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'delete',
                'description' => 'The user can delete branch',
                'group' => 'branch',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'create',
                'description' => 'The user can create department',
                'group' => 'department',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'edit',
                'description' => 'The user can edit department',
                'group' => 'department',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'view',
                'description' => 'The user can view department',
                'group' => 'department',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'delete',
                'description' => 'The user can delete department',
                'group' => 'department',
                'can_access' => ['creator administrator', 'admin manager']
            ],
            [
                'name' => 'create',
                'description' => 'The user can create groups',
                'group' => 'groups',
                'can_access' => ['creator administrator', 'admin manager']
            ],

        ];

        $roles = [
            [
                'name' => 'creator administrator',
                'description' => 'Create and edit core functions/features'
            ],
            [
                'name' => 'admin manager',
                'description' => 'Edit limited functions/features, approve budget'
            ],
            [
                'name' => 'users',
                'description' => 'Create, edit and approve budget'
            ]
        ];

        collect($permissions)->map(function ($permission) {
            Permission::create([
                'name' => "{$permission['name']} {$permission['group']}",
                'description' => $permission['description'],
                'group' => $permission['group']
            ]);
        });

        collect($roles)->each(function ($role) use ($permissions) {
            $role = Role::create($role);
            $mappedPermissions = collect($permissions)->filter(function ($permission) use ($role) {
                return in_array($role['name'], $permission['can_access']);
            })->map(function ($permission) {
                return "{$permission['name']} {$permission['group']}";
            });

            $role->syncPermissions($mappedPermissions);
        });
    }
}