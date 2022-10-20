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
            'character-edit' => [$admin, $registrar, $gamemaster],
            'character-view' => [$admin, $registrar, $gamemaster],
            'character-delete' => [$admin, $registrar, $gamemaster],
            'character-force-delete' => [$admin],
            'character-restore' => [$admin, $registrar, $gamemaster],
            'character-create-unlimited' => [$admin],
            'character-create-vox' => [$admin],

            'application-index' => [$admin, $registrar, $gamemaster],
            'application-take-for-approval' => [$admin, $registrar],
            'application-cancel-approval' => [$admin, $registrar],
            'application-request-changes' => [$admin, $registrar],
            'application-request-approval' => [$admin, $registrar],
            'application-approve' => [$admin, $registrar],
            'application-reapproval' => [$admin, $registrar, $gamemaster],

            'user-index' => [$admin, $registrar, $gamemaster],
            'user-view' => [$admin, $registrar, $gamemaster],
            'user-edit' => [$admin],
            'user-manage' => [$admin],
            'user-delete' => [$admin],
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
