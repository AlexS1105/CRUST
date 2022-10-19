<?php

namespace Database\Seeders;

use App\Enums\PerkType;
use App\Models\Perk;
use App\Models\PerkVariant;
use Illuminate\Database\Seeder;

class PerkSeeder extends Seeder
{
    public function run()
    {
        for ($k = 0; $k <= 10; $k++) {
            $perk = Perk::factory()->create(['type' => PerkType::None]);
            $amount = rand(1, 3);

            if (rand(1, 2) === 1) {
                $perk->type = PerkType::set($perk->type, PerkType::Combat);

                if (rand(1, 3) === 1) {
                    $perk->type = PerkType::set($perk->type, PerkType::Attack);
                } elseif (rand(1, 3) === 1) {
                    $perk->type = PerkType::set($perk->type, PerkType::Defence);
                }
            }

            $perk->save();

            for ($i = 0; $i <= $amount; $i++) {
                PerkVariant::factory()->create(['perk_id' => $perk->id]);
            }
        }
    }
}
