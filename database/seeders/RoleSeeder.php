<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $registrar = Role::create(['name' => 'registrar']);
        $gamemaster = Role::create(['name' => 'gamemaster']);
        $admin = Role::create(['name' => 'admin']);

        $permissions = [
            'character-edit' => [$registrar, $gamemaster],
            'character-view' => [$registrar, $gamemaster],
            'character-delete' => [$registrar, $gamemaster],
            
            'application-index' => [$registrar, $gamemaster],
            'application-take-for-approval' => [$registrar],
            'application-cancel-approval' => [$registrar],
            'application-approve' => [$registrar],
            'application-reapproval' => [$registrar, $gamemaster]
        ];

        foreach ($permissions as $permission => $roles) {
            Permission::create(['name' => $permission]);

            foreach ($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
