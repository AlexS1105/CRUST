<?php

namespace App\Enums;

enum FateType: int
{
    case None = 0;
    case Ambition = 1 << 0;
    case Flaw = 1 << 1;
    case Continuous = 1 << 2;
}
