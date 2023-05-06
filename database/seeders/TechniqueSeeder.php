<?php

namespace Database\Seeders;

use App\Models\Talent;
use App\Models\Technique;
use Illuminate\Database\Seeder;

class TechniqueSeeder extends Seeder
{
    public function run()
    {
        Technique::factory(16)->create();
    }
}
