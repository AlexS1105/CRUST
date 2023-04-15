<?php

namespace App\Models;

use App\Services\CharacterService;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function bonus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $character = $this->character;
                $value = $character->charsheet->stats[$this->skill->stat->value] ?? 0;

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
        );
    }

    public function cost(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->level) {
                default => 0,
                1 => 1,
                2 => 3,
                3 => 5,
            }
        );
    }

    public static function booted()
    {
        static::updated(function ($skill) {
            app(CharacterService::class)->syncCharsheet($skill->character);
        });
    }
}
