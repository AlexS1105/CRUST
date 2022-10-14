<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DiscordTag implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^.*#[0-9]{4}$/', $value);
    }

    public function message()
    {
        return __('validation.discordtag');
    }
}
