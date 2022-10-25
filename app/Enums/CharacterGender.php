<?php

namespace App\Enums;

enum CharacterGender: int
{
    case Male = 0;
    case Female = 1;
    case Other = 2;

    public function icon()
    {
        return match ($this) {
            CharacterGender::Male => 'fa-mars',
            CharacterGender::Female => 'fa-venus',
            CharacterGender::Other => 'fa-genderless',
        };
    }

    public function color()
    {
        return match ($this) {
            CharacterGender::Male => 'text-blue-600',
            CharacterGender::Female => 'text-pink-400',
            CharacterGender::Other => 'text-gray-400',
        };
    }

    public function localized()
    {
        return __('characters.gender.'.strtolower($this->name));
    }
}
