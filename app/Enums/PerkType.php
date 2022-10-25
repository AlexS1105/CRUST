<?php

namespace App\Enums;

enum PerkType: int
{
    case None = 0;
    case Combat = 1 << 0;
    case Attack = 1 << 1;
    case Defence = 1 << 2;
}
