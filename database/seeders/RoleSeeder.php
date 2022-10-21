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

        $registrar = Role::findOrCreate('registrar');
        $gamemaster = Role::findOrCreate('gamemaster');
        $admin = Role::findOrCreate('admin');

        $permissions = [
            'character-create-unlimited' => [$admin],
            'character-view' => [$admin, $gamemaster],
            'character-manage' => [$admin, $gamemaster],
            'character-force-delete' => [$admin],
            'character-vox' => [$admin],

            'application-view' => [$admin, $registrar, $gamemaster],
            'application-approval' => [$admin, $registrar],
            'application-admin' => [$admin],

            'user-view' => [$admin, $registrar, $gamemaster],
            'user-edit' => [$admin],
            'user-manage' => [$admin],
            'user-ban' => [$admin],
            'user-accounts' => [$admin],

            'settings' => [$admin],
            'logs' => [$admin],
        ];

        foreach ($permissions as $permission => $roles) {
            Permission::create(['name' => $permission]);

            foreach ($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
