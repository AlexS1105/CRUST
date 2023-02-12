<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Charsheet;
use App\Models\Perk;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $perks = Perk::all();

        User::factory(10)
            ->has(
                Character::factory(3)
                    ->hasCharsheet(Charsheet::factory()->create())
                    ->hasAttached($perks->random(3), ['note' => fake()->sentence()])
                    ->hasNarrativeCrafts(3)
                    ->hasExperiences(3)
                    ->hasSpheres(3)
                    ->hasIdeas(3)
                    ->hasFates(3)
            )
            ->create();

        User::first()->assignRole('admin');
        User::find(2)->assignRole('registrar');
        User::find(3)->assignRole('gamemaster');
    }
}
