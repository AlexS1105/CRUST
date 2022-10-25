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
            $type = 0;
            $amount = rand(1, 3);

            if (rand(1, 2) === 1) {
                $type = PerkType::set($type, PerkType::Combat);

                if (rand(1, 2) === 1) {
                    $type = PerkType::set($type, PerkType::Attack);
                } else {
                    $type = PerkType::set($type, PerkType::Defence);
                }
            }

            $perk->type = $type;

            $perk->save();

            for ($i = 0; $i <= $amount; $i++) {
                PerkVariant::factory()->create(['perk_id' => $perk->id]);
            }
        }
    }
}
