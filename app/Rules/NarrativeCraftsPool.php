<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NarrativeCraftsPool implements Rule
{
    protected $skills;

    public function __construct($skills)
    {
        $this->skills = $skills;
    }

    public function passes($attribute, $narrativeCrafts)
    {
        $skills = $this->skills;
        $magicMax = $skills['magic'];
        $techMax = $skills['tech'];
        
        return count($narrativeCrafts) <= floor(($magicMax + $techMax) / 2);
    }

    public function message()
    {
        return __('validation.narrative_crafts');
    }
}
