<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IdeaToSphere implements Rule
{
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        return $this->character->spheres->contains($value);
    }

    public function message()
    {
        return __('validation.spheres.not_belongs');
    }
}
