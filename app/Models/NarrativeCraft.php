<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NarrativeCraft
 *
 * @property int $id
 * @property int $character_id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Character $character
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft query()
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NarrativeCraft whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NarrativeCraft extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
