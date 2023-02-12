<?php

namespace App\Enums;

enum CharacterOrigin: int
{
    case Limbborn = 0;
    case Planeborn = 1;
    case Undead = 2;
    case Incarnated = 3;

    public function localized()
    {
        return __('characters.origin.'.strtolower($this->name));
    }
}
