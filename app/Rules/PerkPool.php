<?php

namespace App\Rules;

use App\Enums\PerkType;
use App\Settings\CharsheetSettings;
use Illuminate\Contracts\Validation\Rule;

class PerkPool implements Rule
{
    public $message = 'validation.perkpool.invalid';
    public $edit = false;

    public function __construct($edit)
    {
        $this->edit = $edit;
    }

    public function passes($attribute, $value)
    {
        $maxPerks = app(CharsheetSettings::class)->perk_points;
        $maxActivePerks = app(CharsheetSettings::class)->max_active_perks;
        $combatPerkPoints = 0;
        $noncombatPerkPoints = 0;

        $combatPerks = 0;
        $noncombatPerks = 0;

        foreach($value as $perkData) {
            $perk = $perkData['variant']->perk;
            $isNative = $perk->type->hasFlag(PerkType::Native);

            if ($perk->type->hasFlag(PerkType::Unique)) {
                $this->message = 'validation.perkpool.unique';

                return false;
            }

            $cost = $perk->cost;
            $costOffset = $perkData['cost_offset'] ?? 0;

            $cost += $costOffset;

            if ($perk->type->isCombat()) {
                $combatPerkPoints += $cost;

                if ($perkData['active'] && !$isNative) {
                    $combatPerks += 1;
                }
            } else {
                $noncombatPerkPoints += $cost;

                if ($perkData['active'] && !$isNative) {
                    $noncombatPerks += 1;
                }
            }
        }

        if (!$this->edit) {
            if ($combatPerkPoints > $maxPerks) {
                $this->message = 'validation.perkpool.not_enough_combat';
    
                return false;
            }
    
            if ($noncombatPerkPoints > $maxPerks) {
                $this->message = 'validation.perkpool.not_enough_noncombat';
    
                return false;
            }
        }

        if ($combatPerks > $maxActivePerks) {
            $this->message = 'validation.perkpool.too_much_combat';

            return false;
        }

        if ($noncombatPerks > $maxActivePerks) {
            $this->message = 'validation.perkpool.too_much_noncombat';

            return false;
        }
        
        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
