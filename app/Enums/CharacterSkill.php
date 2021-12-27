<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterSkill extends Enum
{
    const Fitness = 0;
    const Perception = 1;
    const Agility = 2;
    const Coordination = 3;
    const Ingenuity = 4;
    const Tech = 5;
    const Magic = 6;
    const Charisma = 7;
    const Composure = 8;

    public function key()
    {
        return strtolower($this->description);
    }

    public function localized()
    {
        return __('skill.'.strtolower($this->description));
    }
}
