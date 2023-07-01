<?php

namespace App\Models;

use App\Enums\CharacterStat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Skill
 *
 * @property int $id
 * @property int $proficiency
 * @property string $name
 * @property string $description
 * @property CharacterStat $stat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Advantage> $advantages
 * @property-read int|null $advantages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @property-read int|null $characters_count
 * @method static \Database\Factories\SkillFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereProficiency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereStat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Advantage> $advantages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Advantage> $advantages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @mixin \Eloquent
 */
class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'proficiency',
        'name',
        'description',
        'stat',
    ];

    protected $casts = [
        'stat' => CharacterStat::class,
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot('level')->using(CharacterSkill::class);
    }

    public function advantages()
    {
        return $this->hasMany(Advantage::class)->orderBy('level');
    }
}
