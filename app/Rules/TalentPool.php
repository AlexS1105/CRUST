<?php

namespace App\Rules;

use App\Models\Talent;
use Illuminate\Contracts\Validation\Rule;

class TalentPool implements Rule
{
    public $message = 'validation.talent_pool.invalid';
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        $maxTalents = $this->character->max_talent_amount;
        $talentPoints = request('talent_points', $this->character->talent_points);
        $talents = Talent::all();

        $talentAmount = count($value);
        $talentSum = 0;

        foreach ($value as $talentId => $talentData) {
            $talent = $talents->firstWhere('id', $talentId);

            if ($talent != null) {
                $talentSum += $talent->cost;
            } else {
                $this->message = 'validation.talent_pool.invalid';

                return false;
            }
        }

        if ($talentAmount > $maxTalents) {
            $this->message = 'validation.talent_pool.too_much';

            return false;
        }

        if ($talentSum > $talentPoints) {
            $this->message = 'validation.talent_pool.no_points';

            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
