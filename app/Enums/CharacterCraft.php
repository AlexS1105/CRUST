<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterCraft extends Enum
{
    public const Arc = 0;
    public const Mys = 1;
    public const Wiz = 2;
    public const Mnf = 3;
    public const Eng = 4;
    public const Gun = 5;
    public const Chm = 6;
    public const Smt = 7;
    public const Bld = 8;
    public const Med = 9;

    protected $tiers = [
        CharacterCraft::Arc => 3,
        CharacterCraft::Mys => 3,
        CharacterCraft::Wiz => 2,
        CharacterCraft::Mnf => 3,
        CharacterCraft::Eng => 3,
        CharacterCraft::Gun => 2,
        CharacterCraft::Chm => 2,
        CharacterCraft::Smt => 2,
        CharacterCraft::Bld => 1,
        CharacterCraft::Med => 1,
    ];

    public static function getMagicCrafts()
    {
        return [
            CharacterCraft::Arc(),
            CharacterCraft::Mys(),
            CharacterCraft::Wiz(),
        ];
    }

    public static function getTechCrafts()
    {
        return [
            CharacterCraft::Mnf(),
            CharacterCraft::Eng(),
            CharacterCraft::Gun(),
        ];
    }

    public static function getGeneralCrafts()
    {
        return [
            CharacterCraft::Chm(),
            CharacterCraft::Smt(),
            CharacterCraft::Bld(),
            CharacterCraft::Med(),
        ];
    }

    public function getMaxTier()
    {
        return $this->tiers[$this->value];
    }

    public function getType()
    {
        return in_array($this, $this->getMagicCrafts()) ? 'magic' :
            (in_array($this, $this->getTechCrafts()) ? 'tech' : 'general');
    }

    public function isMagic()
    {
        return in_array($this, $this->getMagicCrafts());
    }

    public function isTech()
    {
        return in_array($this, $this->getTechCrafts());
    }

    public function isGeneral()
    {
        return ! $this->isMagic() && ! $this->isTech();
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
