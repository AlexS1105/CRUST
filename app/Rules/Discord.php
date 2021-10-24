<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Discord implements Rule
{

    public function passes($attribute, $value)
    {
        return preg_match('/^.{3,32}#[0-9]{4}$/', $value);
    }

    public function message()
    {
        return 'The :attribute must be valid discord tag.';
    }
}
