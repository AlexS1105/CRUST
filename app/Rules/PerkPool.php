<?php

namespace App\Rules;

use App\Models\Perk;
use App\Settings\CharsheetSettings;
use Illuminate\Contracts\Validation\Rule;

class PerkPool implements Rule
{
    public $message = 'validation.perk_pool.invalid';
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        $settings = app(CharsheetSettings::class);
        $maxPerks = $settings->max_perks;
        $perkPoints = request('perk_points', $this->character->perk_points);
        $perks = Perk::all();

        $perksAmount = count($value);
        $perkSum = 0;

        foreach ($value as $perkId => $perkData) {
            $perk = $perks->firstWhere('id', $perkId);

            if ($perk != null) {
                $perkSum += $perk->cost;
            } else {
                $this->message = 'validation.perk_pool.invalid';

                return false;
            }
        }

        if ($perksAmount > $maxPerks) {
            $this->message = 'validation.perk_pool.too_much';

            return false;
        }

        if ($perkSum > $perkPoints) {
            $this->message = 'validation.perk_pool.no_points';

            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
