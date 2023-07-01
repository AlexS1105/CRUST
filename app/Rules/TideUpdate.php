<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TideUpdate implements Rule
{
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $reason)
    {
        $request = request();
        $tides = $request->tides;
        $characterTides = $this->character->tides;

        foreach ($tides as $id => $tide) {
            if ($tide['level'] != $characterTides->firstWhere('id', $id)->level) {
                return ! empty($reason);
            }
        }

        return true;
    }

    public function message()
    {
        return __('validation.reason.required');
    }
}
