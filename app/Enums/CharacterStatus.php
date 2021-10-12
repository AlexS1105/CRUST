<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterStatus extends Enum
{
    const Blank = 0;
    const Pending = 1;
    const Approved = 2;
    const Deleting = 3;

    static public function getColor($status) {
        $colors = [
            CharacterStatus::Blank => "gray-400",
            CharacterStatus::Pending => "blue-400",
            CharacterStatus::Approved => "green-400",
            CharacterStatus::Deleting => "red-400"
        ];

        return $colors[$status->value];
    }
}
