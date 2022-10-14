<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterStatus extends Enum
{
    public const Blank = 0;
    public const Pending = 1;
    public const Approval = 2;
    public const ChangesRequested = 3;
    public const Approved = 4;
    public const Deleting = 5;

    protected $colors = [
        CharacterStatus::Blank => 'gray-400',
        CharacterStatus::Pending => 'blue-400',
        CharacterStatus::Approval => 'yellow-300',
        CharacterStatus::ChangesRequested => 'yellow-600',
        CharacterStatus::Approved => 'green-400',
        CharacterStatus::Deleting => 'red-400',
    ];

    public function color()
    {
        return $this->colors[$this->value];
    }

    public function localized()
    {
        return __('characters.status.'.str_replace(' ', '_', strtolower($this->description)));
    }
}
