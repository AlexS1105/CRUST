<?php

namespace App\Rules;

use App\Enums\PerkType;
use App\Settings\CharsheetSettings;
use Illuminate\Contracts\Validation\Rule;

class PerkPool implements Rule
{
    public $message = 'validation.perkpool.invalid';

    public function passes($attribute, $value)
    {
        $maxPerks = app(CharsheetSettings::class)->perk_points;
        $combatPerkPoints = 0;
        $noncombatPerkPoints = 0;

        foreach($value as $perkData) {
            $perk = $perkData['variant']->perk;

            if ($perk->type->hasFlag(PerkType::Unique)) {
                $this->message = 'validation.perkpool.unique';

                return false;
            }

            $cost = $perk->cost;
            $costOffset = $perkData['cost_offset'] ?? 0;

            $cost += $costOffset;

            if ($perk->type->isCombat()) {
                $combatPerkPoints += $cost;
            } else {
                $noncombatPerkPoints += $cost;
            }
        }

        if ($combatPerkPoints > $maxPerks) {
            $this->message = 'validation.perkpool.not_enough_combat';

            return false;
        }

        if ($noncombatPerkPoints > $maxPerks) {
            $this->message = 'validation.perkpool.not_enough_noncombat';

            return false;
        }
        
        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
