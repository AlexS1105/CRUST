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
        $maxActivePerks = app(CharsheetSettings::class)->max_active_perks;

        $combatPerks = 0;
        $noncombatPerks = 0;

        foreach($value as $perkData) {
            $perk = $perkData['variant']->perk;
            $isNative = $perk->type->hasFlag(PerkType::Native);

            if ($perk->type->hasFlag(PerkType::Unique) && !$this->edit) {
                $this->message = 'validation.perkpool.unique';

                return false;
            }

            if ($perk->type->isCombat() && $perkData['active'] && !$isNative) {
                $combatPerks += 1;
            } else {
                $noncombatPerks += 1;
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
