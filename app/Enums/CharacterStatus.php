<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterStatus extends Enum
{
    const Blank = 0;
    const Pending = 1;
    const Approved = 2;
    const Deleting = 3;
}
