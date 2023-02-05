<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Estitence implements Rule
{
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $estitence)
    {
        return $this->character->estitence + $estitence >= 0;
    }

    public function message()
    {
        return __('validation.estitence.not_enough');
    }
}
