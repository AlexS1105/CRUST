<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Experience implements Rule
{
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $experience)
    {
        return $this->character->experience + $experience >= 0;
    }

    public function message()
    {
        return __('validation.experience.not_enough');
    }
}
