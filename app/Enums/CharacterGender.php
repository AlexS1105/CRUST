<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterGender extends Enum
{
    const Male = 0;
    const Female = 1;
    const Other = 2;

    protected $icons = [
        CharacterGender::Male => 'fa-mars',
        CharacterGender::Female => 'fa-venus',
        CharacterGender::Other => 'fa-genderless', 
    ];

    protected $colors = [
        CharacterGender::Male => 'blue-400',
        CharacterGender::Female => 'pink-400',
        CharacterGender::Other => 'gray-400',
    ];

    public function icon()
    {
        return $this->icons[$this->value];
    }

    public function color()
    {
        return $this->colors[$this->value];
    }

    public function localized()
    {
        return __('characters.gender.'.strtolower($this->description));
    }
}
