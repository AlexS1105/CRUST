<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Charsheet;
use App\Models\Perk;
use App\Models\Skill;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $perks = Perk::all();
        $skills = Skill::all();
        $talents = Talent::all();

        User::factory(10)
            ->has(
                Character::factory(3)
                    ->hasCharsheet(Charsheet::factory()->create())
                    ->hasAttached($perks->random(3), ['note' => fake()->sentence()])
                    ->hasAttached($skills->random(5), ['level' => fake()->numberBetween(1, 3)])
                    ->hasAttached($talents->random(3), [], 'talents')
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
