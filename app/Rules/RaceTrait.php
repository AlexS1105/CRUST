<?php

namespace App\Rules;

use App\Models\RaceTrait as ModelsRaceTrait;
use App\Settings\CharsheetSettings;
use Illuminate\Contracts\Validation\Rule;

class RaceTrait implements Rule
{
    public function passes($attribute, $trait)
    {
        if ($trait != null) {
            if ($trait) {
                return !$trait->subtrait;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function message()
    {
        return __('validation.trait');
    }
}
