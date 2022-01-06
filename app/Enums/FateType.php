<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

final class FateType extends FlaggedEnum
{
    const Ambition = 1 << 0;
    const Flaw = 1 << 1;
    const Continious  = 1 << 2;

    public function isDual()
    {
        return $this->hasFlags([FateType::Ambition, FateType::Flaw]);
    }

    public function isOnetime()
    {
        return $this->notHasFlag(FateType::Continious);
    }
}
