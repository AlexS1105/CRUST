<?php

namespace Database\Seeders;

use App\Models\Perk;
use Illuminate\Database\Seeder;

class PerkSeeder extends Seeder
{
    public function run()
    {
        Perk::factory(30)->create();
    }
}
