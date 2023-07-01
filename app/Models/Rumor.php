<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rumor
 *
 * @property int $id
 * @property int $character_id
 * @property int $user_id
 * @property string $text
 * @property \App\Enums\Tide $tide
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Character $character
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor actual()
 * @method static \Database\Factories\RumorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereTide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumor whereUserId($value)
 * @mixin \Eloquent
 */
class Rumor extends Model
{
    use HasFactory;

    protected $fillable = [
        'tide',
        'text',
        'user_id',
    ];

    protected $casts = [
        'tide' => \App\Enums\Tide::class,
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActual($query)
    {
        return $query->limit(5);
    }
}
