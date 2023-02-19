<?php

namespace Database\Seeders;

use App\Models\Talent;
use Illuminate\Database\Seeder;

class TalentSeeder extends Seeder
{
    public function run()
    {
        Talent::factory(16)->create();
    }
}
