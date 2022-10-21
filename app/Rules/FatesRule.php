<?php

namespace App\Rules;

use App\Enums\FateType;
use Illuminate\Contracts\Validation\Rule;

class FatesRule implements Rule
{
    public $message = 'validation.fates.invalid';

    public function passes($attribute, $fates)
    {
        $dualFates = 0;

        if (isset($fates)) {
            foreach ($fates as $fate) {
                if (FateType::all($fate['type'], FateType::Ambition, FateType::Flaw)) {
                    $dualFates += 1;
                }
            }

            if ($dualFates > 1) {
                $this->message = 'validation.fates.one_dual';

                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
