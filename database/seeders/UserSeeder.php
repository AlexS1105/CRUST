<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Charsheet;
use App\Models\Perk;
use App\Models\Rumor;
use App\Models\Skill;
use App\Models\Talent;
use App\Models\Technique;
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
        $techniques = Technique::all();

        $users = User::factory(10)
            ->create();

        Character::factory(30)
            ->recycle($users)
            ->hasCharsheet(Charsheet::factory()->create())
            ->hasAttached($perks->random(3), ['note' => fake()->sentence()])
            ->hasAttached($skills->random(5), ['level' => fake()->numberBetween(1, 3)])
            ->hasAttached($talents->random(3), [], 'talents')
            ->hasAttached($techniques->random(3), [], 'techniques')
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
            ->has(
                Rumor::factory(5)
                    ->recycle($users)
            )
            ->create();

        User::first()->assignRole('admin');
        User::find(2)->assignRole('registrar');
        User::find(3)->assignRole('gamemaster');
    }
}
