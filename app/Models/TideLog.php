<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExperienceLog
 *
 * @property int $id
 * @property int $character_id
 * @property int|null $issued_by
 * @property int $before
 * @property int $after
 * @property int $delta
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Character $character
 * @property-read \App\Models\User|null $issuedBy
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereDelta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExperienceLog whereUpdatedAt($value)
 *
 * @property \App\Enums\Tide $tide
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TideLog whereTide($value)
 *
 * @mixin \Eloquent
 */
class TideLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tide' => \App\Enums\Tide::class,
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
