<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Idea
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $character_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Character $character
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Idea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Idea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Idea query()
 * @method static \Illuminate\Database\Eloquent\Builder|Idea whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Idea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Idea whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Idea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Idea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Idea whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Idea extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
