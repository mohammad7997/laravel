<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::where('name', config('permission.default_roles')[0]);
        if ($roles->count() < 1) {
            foreach (config('permission.default_roles') as $role){
                Role::create([
                    'name'=>$role
                ]);
            }
        }

        $permissionInDatabases = Permission::where('name', config('permission.default_permission')[0]);
        if ($permissionInDatabases->count() < 1) {
            foreach (config('permission.default_permission') as $permissionInDatabase){
                Permission::create([
                    'name'=>$permissionInDatabase
                ]);
            }
        }
    }
}
