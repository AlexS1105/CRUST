<?php

namespace App\Rules;

use App\Enums\FateType;
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
        $ambitions = 0;
        $flaws = 0;

        foreach($fates as $fate) {
            if ($fate['type'] === null) {
                continue;
            }

            if ($fate['type']->isDual()) {
                $dualFates += 1;
            } elseif ($fate['type']->hasFlag(FateType::Ambition)) {
                $ambitions += 1;
            } elseif ($fate['type']->hasFlag(FateType::Flaw)) {
                $flaws += 1;
            }
        }

        if (!$this->edit) {
            if ($dualFates == 1 && ($ambitions > 0 || $flaws > 0)) {
                $this->message = 'validation.fates.dual_only';
    
                return false;
            }

            if ($ambitions > 1) {
                $this->message = 'validation.fates.one_ambition';
    
                return false;
            }
    
            if ($flaws > 1) {
                $this->message = 'validation.fates.one_flaw';
    
                return false;
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
