<?php

namespace App\Rules;

use App\Enums\CharacterCraft;
use Illuminate\Contracts\Validation\Rule;

class CraftPool implements Rule
{
    protected $skills;
    protected $narrative_crafts;
    protected $message = 'validation.craftpool.invalid';

    public function __construct($skills, $narrative_crafts)
    {
        $this->skills = $skills;
        $this->narrative_crafts = $narrative_crafts;
    }

    public function passes($attribute, $crafts)
    {
        $skills = $this->skills;
        $magicMax = $skills['magic'];
        $techMax = $skills['tech'];
        $ingenuityPoints = $skills['ingenuity'];
        $magicPoints = 0;
        $techPoints = 0;
        $generalPoints = 0;
        $tiers = [
            'magic' => 0,
            'tech' => 0,
            'general' => 0
        ];

        foreach($crafts as $craft => $value) {
            $type = CharacterCraft::fromKey(ucfirst($craft))->getType();

            if ($value > 0) {
                $tiers[$type] += 1;
            }
        }

        foreach($tiers as $value) {
            if ($value > 2) {
                $this->message = 'validation.craftpool.maxtiers';
                return false;
            }
        }

        foreach($crafts as $craft => $value) {
            $type = CharacterCraft::fromKey(ucfirst($craft))->getType();
            $cost = $value;

            ${$type."Points"} += $cost;
        }

        if ($magicPoints > $magicMax) {
            $this->message = 'validation.craftpool.magic';
            return false;
        }

        if ($techPoints > $techMax) {
            $this->message = 'validation.craftpool.tech';
            return false;
        }

        $freeGeneralPoints = $techMax - $techPoints + $magicMax - $magicPoints - $generalPoints + $ingenuityPoints;

        if ($freeGeneralPoints < 0) {
            $this->message = 'validation.craftpool.general';
            return false;
        }

        if (count($this->narrative_crafts) > floor(($magicMax + $techMax + $ingenuityPoints) / 2) + $freeGeneralPoints) {
            $this->message = 'validation.craftpool.narrative_crafts';
            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
