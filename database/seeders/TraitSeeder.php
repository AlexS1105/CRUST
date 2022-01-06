<?php

namespace Database\Seeders;

use App\Models\RaceTrait;
use Illuminate\Database\Seeder;

class TraitSeeder extends Seeder
{
    public function run()
    {
        RaceTrait::factory(10)->create();
    }
}
