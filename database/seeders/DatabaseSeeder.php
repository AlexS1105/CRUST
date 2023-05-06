<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PerkSeeder::class,
            SkillSeeder::class,
            TalentSeeder::class,
            TechniqueSeeder::class,
            UserSeeder::class,
        ]);
    }
}
