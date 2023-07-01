<?php

namespace App\Models;

use App\Enums\CharacterTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Advantage
 *
 * @property int $id
 * @property int $skill_id
 * @property int $level
 * @property string $description
 * @property int $is_penalty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $titled
 *
 * @method static \Database\Factories\AdvantageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereIsPenalty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereTitled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advantage whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Advantage extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'level',
        'is_penalty',
        'titled',
    ];

    public function visibleFor(Character $character, int $bonus)
    {
        return ($bonus <= $this->level && $this->is_penalty
                || $bonus >= $this->level && ! $this->is_penalty)
            && ($this->titled && $character->title != CharacterTitle::None
                || ! $this->titled);
    }
}
