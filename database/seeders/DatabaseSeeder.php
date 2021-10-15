<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Character;
use App\Models\Charsheet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class
        ]);

        //User::factory(10)->create();
        //Character::factory(10)->create();
        Charsheet::factory(10)->create();

        User::first()->assignRole('admin');
        User::find(2)->assignRole('registrar');
        User::find(3)->assignRole('gamemaster');
    }
}
