<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

final class PerkType extends FlaggedEnum
{
    const Combat = 1 << 0;
    const Native = 1 << 1;
    const Unique  = 1 << 2;

    public function isCombat()
    {
        return $this->hasFlag(PerkType::Combat);
    }

    public function isNonCombat()
    {
        return $this->notHasFlag(PerkType::Combat);
    }
}
