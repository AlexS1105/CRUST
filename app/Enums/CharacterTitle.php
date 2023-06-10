<?php

namespace App\Enums;

enum CharacterTitle: string
{
    case None = 'none';
    case Champion = 'champion';
    case Hero = 'hero';
    case Keeper = 'keeper';
    case God = 'god';
    case Aeon = 'aeon';
    case Relic = 'relic';

    public function localized()
    {
        return __('title.' . $this->value);
    }
}
