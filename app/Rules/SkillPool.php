<?php

namespace App\Rules;

use App\Settings\CharsheetSettings;
use Illuminate\Contracts\Validation\Rule;

class SkillPool implements Rule
{
    public function passes($attribute, $value)
    {
        return array_sum($value) <= app(CharsheetSettings::class)->skill_points;
    }

    public function message()
    {
        return __('validation.skillpool');
    }
}
