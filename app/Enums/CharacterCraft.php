<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CharacterCraft extends Enum
{
    const Arc = 0;
    const Mys = 1;
    const Wiz = 2;
    const Mnf = 3;
    const Eng = 4;
    const Gun = 5;
    const Chm = 6;
    const Smt = 7;
    const Bld = 8;
    const Med = 9;

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
        CharacterCraft::Med => 1
    ];

    static public function getMagicCrafts()
    {
        return [
            CharacterCraft::Arc(),
            CharacterCraft::Mys(),
            CharacterCraft::Wiz()
        ];
    }

    static public function getTechCrafts()
    {
        return [
            CharacterCraft::Mnf(),
            CharacterCraft::Eng(),
            CharacterCraft::Gun()
        ];
    }

    static public function getGeneralCrafts()
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
        return !$this->isMagic() && !$this->isTech();
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
