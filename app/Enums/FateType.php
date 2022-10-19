<?php

namespace App\Enums;

use FramJet\Packages\EnumBitmask\BitmaskFunctionality;

enum FateType: int
{
    use BitmaskFunctionality;

    case None = 0;
    case Ambition = 1 << 0;
    case Flaw = 1 << 1;
    case Continuous = 1 << 2;
}
