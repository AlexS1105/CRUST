<?php

namespace App\Rules;

use App\Models\Skill;
use Illuminate\Contracts\Validation\Rule;

class SkillPool implements Rule
{
    public $message = 'validation.skill_pool.invalid';
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        $skillPoints = $this->character->skill_points;
        $skills = Skill::all();
        $sum = 0;

        foreach ($value as $id => $skill) {
            if ($skills->firstWhere('id', $id) == null) {
                return false;
            }

            $sum += match($skill) {
                '1' => 1,
                '2' => 3,
                '3' => 5,
            };
        }

        if ($sum > $skillPoints) {
            $this->message = 'validation.skill_pool.no_points';
            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message());
    }
}
