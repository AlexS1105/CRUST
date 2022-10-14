<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

final class FateType extends FlaggedEnum
{
    public const Ambition = 1 << 0;
    public const Flaw = 1 << 1;
    public const Continious = 1 << 2;

    public function isDual()
    {
        return $this->hasFlags([FateType::Ambition, FateType::Flaw]);
    }

    public function isOnetime()
    {
        return $this->notHasFlag(FateType::Continious);
    }
}
