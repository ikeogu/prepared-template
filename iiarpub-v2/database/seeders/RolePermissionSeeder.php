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
     *
     * @return void
     */
    public function run()
    {
        //
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

        ];

        $roles = [
            [
                'name' => 'creator administrator',
                'description' => 'Create and edit core functions/features'
            ],
            [
                'name' => 'admin manager',
                'description' => 'Edit core functions/features'
            ],
            [
                'name' => 'editor',
                'description' => 'Edit limited functions/features'
            ],
            [
                'name' => 'user',
                'description' => 'Submit Paperwork'
            ],
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