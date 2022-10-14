<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterSkill extends Enum
{
    public const Fitness = 0;
    public const Perception = 1;
    public const Agility = 2;
    public const Coordination = 3;
    public const Ingenuity = 4;
    public const Tech = 5;
    public const Magic = 6;
    public const Charisma = 7;
    public const Composure = 8;

    public function key()
    {
        return strtolower($this->description);
    }

    public function localized()
    {
        return __('skill.'.strtolower($this->description));
    }
}
