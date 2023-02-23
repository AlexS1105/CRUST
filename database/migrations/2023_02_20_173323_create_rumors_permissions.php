<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up()
    {
        try {

            $admin = Role::findByName('admin');
            $gamemaster = Role::findByName('gamemaster');

            $canSee = Permission::create(['name' => 'rumors-see']);
            $manage = Permission::create(['name' => 'rumors-manage']);

            $admin->givePermissionTo($canSee);
            $admin->givePermissionTo($manage);
            $gamemaster->givePermissionTo($canSee);
            $gamemaster->givePermissionTo($manage);
        } catch (Exception) {

        }
    }

    public function down()
    {
        Permission::findByName('rumors-see')->delete();
        Permission::findByName('rumors-manage')->delete();
    }
};
