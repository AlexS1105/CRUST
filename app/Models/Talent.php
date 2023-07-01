<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Talent
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @property-read int|null $characters_count
 * @method static \Database\Factories\TalentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Talent forCharacter($character)
 * @method static \Illuminate\Database\Eloquent\Builder|Talent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Talent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Talent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Talent whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Talent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Talent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Talent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Talent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Talent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'name',
        'description',
        'cost',
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_talent');
    }

    public function scopeForCharacter($query, $character)
    {
        $talentIds = $character->talents->pluck('id')->implode(',');

        if (empty($talentIds)) {
            return $query;
        }

        return $query->orderByRaw(DB::raw("FIELD(id, {$talentIds}) DESC"));
    }
}
