<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EstitenceLog
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
 * @property-read Character $character
 * @property-read User|null $issuedBy
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereDelta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstitenceLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EstitenceLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($estitenceLog) {
            info('Estitence log created', [
                'user' => auth()->user()?->login,
                'character' => $estitenceLog->character->login,
            ]);
        });

        static::updated(function ($estitenceLog) {
            info('Estitence log updated', [
                'user' => auth()->user()?->login,
                'character' => $estitenceLog->character->login,
            ]);
        });

        static::deleted(function ($estitenceLog) {
            info('Estitence log deleted', [
                'user' => auth()->user()?->login,
                'character' => $estitenceLog->character->login,
            ]);
        });
    }
}
