<?php

namespace Database\Seeders;

use App\Models\Charsheet;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        Charsheet::factory(10)->create();

        User::first()->assignRole('admin');
        User::find(2)->assignRole('registrar');
        User::find(3)->assignRole('gamemaster');
    }
}
