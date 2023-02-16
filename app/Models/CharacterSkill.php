<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CharacterSkill extends Pivot
{
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function bonus()
    {
        $character = $this->character;
        $value = $character->charsheet->skills[$this->skill->stat->value] ?? 0;

        if ($this->level >= 2) {
            $value += $character->soul_coefficient;
        }

        if ($this->level == 1) {
            $value += 1;
        } elseif ($this->level == 3) {
            $value += 3;
        }

        return $value;
    }
}
