<?php

namespace App\Enums;

enum CharacterCraft : string
{
    case Arc = 'arc';
    case Mys = 'mys';
    case Wiz = 'wiz';
    case Mnf = 'mnf';
    case Eng = 'eng';
    case Gun = 'gun';
    case Chm = 'chm';
    case Smt = 'smt';
    case Bld = 'bld';
    case Med = 'med';

    public static function getMagicCrafts()
    {
        return [
            CharacterCraft::Arc,
            CharacterCraft::Mys,
            CharacterCraft::Wiz,
        ];
    }

    public static function getTechCrafts()
    {
        return [
            CharacterCraft::Mnf,
            CharacterCraft::Eng,
            CharacterCraft::Gun,
        ];
    }

    public static function getGeneralCrafts()
    {
        return [
            CharacterCraft::Chm,
            CharacterCraft::Smt,
            CharacterCraft::Bld,
            CharacterCraft::Med,
        ];
    }

    public function getMaxTier()
    {
        return match($this) {
            CharacterCraft::Arc, CharacterCraft::Mys,
            CharacterCraft::Mnf, CharacterCraft::Eng => 3,
            CharacterCraft::Gun, CharacterCraft::Wiz,
            CharacterCraft::Chm, CharacterCraft::Smt => 2,
            CharacterCraft::Bld, CharacterCraft::Med => 1,
        };
    }

    public function getType()
    {
        return match (true) {
            $this->isMagic() => 'magic',
            $this->isTech() => 'tech',
            default => 'general',
        };
    }

    public function isMagic()
    {
        return in_array($this, self::getMagicCrafts());
    }

    public function isTech()
    {
        return in_array($this, self::getTechCrafts());
    }

    public function isGeneral()
    {
        return in_array($this, self::getGeneralCrafts());
    }

    public function key()
    {
        return strtolower($this->name);
    }

    public function localized()
    {
        return __("craft.{$this->key()}");
    }
}
