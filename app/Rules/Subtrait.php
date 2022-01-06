<?php

namespace App\Rules;

use App\Models\RaceTrait;
use Illuminate\Contracts\Validation\Rule;

class Subtrait implements Rule
{
    public function passes($attribute, $trait)
    {
        if ($trait != null) {
            if ($trait) {
                return $trait->subtrait;
            } else {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return __('validation.subtrait');
    }
}
