<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tide
 *
 * @property int $id
 * @property int $character_id
 * @property \App\Enums\Tide $tide
 * @property int $level
 * @property string|null $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Character $character
 *
 * @method static \Database\Factories\TideFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tide query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tide whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tide whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tide wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tide whereTide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tide whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Tide extends Model
{
    use HasFactory;

    protected $fillable = [
        'tide',
        'level',
        'path',
    ];

    protected $casts = [
        'tide' => \App\Enums\Tide::class,
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
