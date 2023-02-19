<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Charsheet;
use App\Models\Perk;
use App\Models\Skill;
use App\Models\Talent;
use App\Models\Tide;
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
                    ->has(
                        Tide::factory(5)
                            ->sequence(
                                ['tide' => \App\Enums\Tide::Red->value],
                                ['tide' => \App\Enums\Tide::Blue->value],
                                ['tide' => \App\Enums\Tide::Indigo->value],
                                ['tide' => \App\Enums\Tide::Gold->value],
                                ['tide' => \App\Enums\Tide::Silver->value],
                            )
                    )
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
