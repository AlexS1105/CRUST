<?php

namespace App\Enums;

enum Tide: string
{
    case Red = 'red';
    case Blue = 'blue';
    case Indigo = 'indigo';
    case Gold = 'gold';
    case Silver = 'silver';

    public function color()
    {
        return match ($this) {
            Tide::Red => 'red',
            Tide::Blue => 'blue',
            Tide::Indigo => 'indigo',
            Tide::Gold => 'yellow',
            Tide::Silver => 'gray',
        };
    }

    public function localized()
    {
        return __('tides.names.' . strtolower($this->name));
    }
}
