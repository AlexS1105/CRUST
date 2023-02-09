<?php

namespace App\Rules;

use App\Enums\CharacterCraft;
use Illuminate\Contracts\Validation\Rule;

class CraftPool implements Rule
{
    protected $skills;
    protected $narrative_crafts;
    protected $message = 'validation.craftpool.invalid';

    public function __construct($skills, $narrative_crafts)
    {
        $this->skills = $skills;
        $this->narrative_crafts = $narrative_crafts;
    }

    public function passes($attribute, $crafts)
    {
        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
