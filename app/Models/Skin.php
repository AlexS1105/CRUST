<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Skin
 *
 * @property int $id
 * @property int $character_id
 * @property string $skin
 * @property string|null $prefix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Character $character
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Skin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereSkin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Skin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($skin) {
            info('Skin created', [
                'user' => auth()->user()->login,
                'character' => $skin->character->login,
                'prefix' => $skin->prefix,
            ]);
        });

        static::deleted(function ($skin) {
            info('Skin deleted', [
                'user' => auth()->user()->login,
                'character' => $skin->character->login,
                'prefix' => $skin->prefix,
            ]);
        });
    }
}
