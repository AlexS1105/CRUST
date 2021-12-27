<?php

namespace App\Rules;

use App\Enums\CharacterCraft;
use Illuminate\Contracts\Validation\Rule;

class CraftPool implements Rule
{
    protected $skills;
    protected $message = 'validation.craftpool.invalid';

    public function __construct($skills)
    {
        $this->skills = $skills;
    }

    public function passes($attribute, $crafts)
    {
        $skills = $this->skills;
        $magicMax = $skills['magic'];
        $techMax = $skills['tech'];
        $magicPoints = 0;
        $techPoints = 0;
        $generalPoints = 0;
        $maxTiers = [
            'magic' => 0,
            'tech' => 0,
            'general' => 0
        ];

        $freeTiers = 0;

        foreach($crafts as $craft => $value) {
            $type = CharacterCraft::fromKey(ucfirst($craft))->getType();

            if ($value === 3) {
                $maxTiers[$type] += 1;
            }
        }

        if (array_sum($maxTiers) > 1) {
            $this->message = 'validation.craftpool.maxtiers';
            return false;
        }

        foreach($crafts as $craft => $value) {
            $type = CharacterCraft::fromKey(ucfirst($craft))->getType();
            $cost = 0;

            if (($maxTiers[$type] > 0 || $type == 'general' && ($maxTiers['magic'] > 0 || $maxTiers['tech'] > 0)) && $freeTiers == 0 && $value == 1) {
                $freeTiers += 1;
            } else {
                for ($i=1; $i <= $value; $i++) { 
                    $cost += $i;
                }
            }

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

        if ($generalPoints > ($techMax - $techPoints + $magicMax - $magicPoints)) {
            $this->message = 'validation.craftpool.general';
            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
