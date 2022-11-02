<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Perk;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $noncombatPerks = Perk::with('variants')->type(0)->get();
        $combatPerks = Perk::with('variants')->where('type', 1)->get();
        $attackPerks = Perk::with('variants')->type(3)->get();
        $defencePerks = Perk::with('variants')->type(5)->get();

        User::factory(10)
            ->has(
                Character::factory(3)
                    ->hasCharsheet()
                    ->hasAttached($noncombatPerks->random(3)->map(function ($perk) {
                        return $perk->variants->random();
                    }), ['active' => true])
                    ->hasAttached($attackPerks->random()->variants->random(), ['active' => true])
                    ->hasAttached($defencePerks->random()->variants->random(), ['active' => true])
                    ->hasAttached($combatPerks->random()->variants->random(), ['active' => true])
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
