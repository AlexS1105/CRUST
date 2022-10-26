<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum CharacterStatus: int
{
    case Blank = 0;
    case Pending = 1;
    case Approval = 2;
    case ChangesRequested = 3;
    case Approved = 4;
    case Deleting = 5;

    public function bgColor()
    {
        return 'bg-'.$this->color();
    }

    public function color()
    {
        return match ($this) {
            CharacterStatus::Blank => 'gray-400',
            CharacterStatus::Pending => 'blue-400',
            CharacterStatus::Approval => 'yellow-300',
            CharacterStatus::ChangesRequested => 'yellow-600',
            CharacterStatus::Approved => 'green-400',
            CharacterStatus::Deleting => 'red-400',
        };
    }

    public function ringColor()
    {
        return 'ring-'.$this->color();
    }

    public function hasRegistrar()
    {
        return match ($this) {
            CharacterStatus::Approval, CharacterStatus::ChangesRequested, CharacterStatus::Approved => true,
            CharacterStatus::Blank, CharacterStatus::Deleting, CharacterStatus::Pending => false,
        };
    }

    public function localized()
    {
        return __('characters.status.'.Str::snake($this->name));
    }
}
