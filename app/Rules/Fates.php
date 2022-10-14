<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Fates implements Rule
{
    public $message = 'validation.fates.invalid';
    public $edit = false;

    public function __construct($edit)
    {
        $this->edit = $edit;
    }

    public function passes($attribute, $fates)
    {
        $dualFates = 0;

        foreach ($fates as $fate) {
            if ($fate['type'] === null) {
                continue;
            }

            if ($fate['type']->isDual()) {
                $dualFates += 1;
            }
        }

        if ($dualFates > 1) {
            $this->message = 'validation.fates.one_dual';

            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
