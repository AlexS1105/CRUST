<?php

namespace App\Enums;

enum CharacterSkill: string
{
    case Fitness = 'fitness';
    case Perception = 'perception';
    case Agility = 'agility';
    case Coordination = 'coordination';
    case Ingenuity = 'ingenuity';
    case Tech = 'tech';
    case Magic = 'magic';
    case Charisma = 'charisma';
    case Composure = 'composure';

    public function localized()
    {
        return __('skill.'.$this->value);
    }
}
