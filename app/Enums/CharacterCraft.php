<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterCraft extends Enum
{
    const Arc = 0;
    const Mys = 1;
    const Enc = 2;
    const Alc = 3;
    const Eng = 4;
    const Mnf = 5;
    const Inf = 6;
    const Chm = 7;
    const Smt = 8;  

    protected $tiers = [
        CharacterCraft::Arc => 3,
        CharacterCraft::Mys => 3,
        CharacterCraft::Enc => 2,
        CharacterCraft::Alc => 1,
        CharacterCraft::Eng => 3,
        CharacterCraft::Mnf => 3,
        CharacterCraft::Inf => 1,
        CharacterCraft::Chm => 1,
        CharacterCraft::Smt => 1
    ];

    static public function getMagicCrafts()
    {
        return [
            CharacterCraft::Arc(),
            CharacterCraft::Mys(),
            CharacterCraft::Enc(),
            CharacterCraft::Alc()
        ];
    }

    static public function getTechCrafts()
    {
        return [
            CharacterCraft::Eng(),
            CharacterCraft::Mnf(),
            CharacterCraft::Inf(),
            CharacterCraft::Chm()
        ];
    }

    static public function getGeneralCrafts()
    {
        return [
            CharacterCraft::Smt()
        ];
    }

    public function getMaxTier()
    {
        return $this->tiers[$this->value];
    }

    public function key()
    {
        return strtolower($this->description);
    }

    public function localized()
    {
        return __('craft.'.strtolower($this->description));
    }
}
