<?php

namespace App\Models;

use App\Services\CharacterService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\CharacterSkill
 *
 * @property int $id
 * @property int $character_id
 * @property int $skill_id
 * @property int $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Character $character
 * @property-read \App\Models\Skill $skill
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacterSkill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
