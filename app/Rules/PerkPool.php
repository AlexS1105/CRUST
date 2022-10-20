<?php

namespace App\Rules;

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
        $attackPerks = 0;
        $defencePerks = 0;

        foreach ($value as $perkData) {
            $perk = $perkData['variant']->perk;

            if ($this->edit && ! $perkData['active']) {
                continue;
            }

            if ($perk->isCombat()) {
                $combatPerks += 1;

                if ($perk->isAttack()) {
                    $attackPerks += 1;
                } elseif ($perk->isDefence()) {
                    $defencePerks += 1;
                }
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

        if ($attackPerks > 1) {
            $this->message = 'validation.perkpool.only_one_attack';

            return false;
        }

        if ($defencePerks > 1) {
            $this->message = 'validation.perkpool.only_one_defence';

            return false;
        }

        if ($attackPerks === 0) {
            $this->message = 'validation.perkpool.one_attack';

            return false;
        }

        if ($defencePerks === 0) {
            $this->message = 'validation.perkpool.one_defence';

            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
