<?php

namespace App\Enums;

enum CharacterStat: string
{
    case Strength = 'strength';
    case Endurance = 'endurance';
    case Perception = 'perception';
    case Agility = 'agility';
    case Determination = 'determination';
    case Erudition = 'erudition';
    case Will = 'will';
    case Potential = 'potential';

    public function localized()
    {
        return __('stat.'.$this->value);
    }
}
