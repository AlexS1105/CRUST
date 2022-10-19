<?php

namespace App\Enums;

use FramJet\Packages\EnumBitmask\BitmaskFunctionality;

enum PerkType: int
{
    use BitmaskFunctionality;

    case None = 0;
    case Combat = 1 << 0;
    case Attack = 1 << 1;
    case Defence = 1 << 2;
}
