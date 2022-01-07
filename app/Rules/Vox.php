<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Vox implements Rule
{
    public $character;
    
    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $vox)
    {
        return ($this->character->vox + $vox) > 0;
    }

    public function message()
    {
        return __('validation.vox.not_enough');
    }
}
