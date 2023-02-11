<?php

namespace App\Rules;

use App\Enums\CharacterStat;
use Illuminate\Contracts\Validation\Rule;

class StatPool implements Rule
{
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        return CharacterStat::getSum($value) <= $this->character->estitence;
    }

    public function message()
    {
        return __('validation.stat.pool');
    }
}
