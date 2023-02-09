<?php

namespace App\Rules;

use App\Settings\CharsheetSettings;
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
        return array_sum($value) <= $this->character->estitence;
    }

    public function message()
    {
        return __('validation.stat_pool');
    }
}
