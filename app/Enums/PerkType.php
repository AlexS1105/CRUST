<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

final class PerkType extends FlaggedEnum
{
    public const Combat = 1 << 0;
    public const Attack = 1 << 1;
    public const Defence = 1 << 2;

    public function isCombat()
    {
        return ! $this->isNonCombat();
    }

    public function isNonCombat()
    {
        return $this->notHasFlags([PerkType::Combat, PerkType::Attack, PerkType::Defence]);
    }
}
