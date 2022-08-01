<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

final class PerkType extends FlaggedEnum
{
    const Combat = 1 << 0;
    const Attack = 1 << 1;
    const Defence = 1 << 2;

    public function isCombat()
    {
        return !$this->isNonCombat();
    }

    public function isNonCombat()
    {
        return $this->notHasFlags([PerkType::Combat, PerkType::Attack, PerkType::Defence]);
    }
}
