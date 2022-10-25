<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VoxLog
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
 * @property-read Character $character
 * @property-read User|null $issuedBy
 *
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereDelta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoxLog whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class VoxLog extends Model
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

        static::created(function ($voxLog) {
            info('Vox log created', [
                'user' => auth()->user()->login,
                'character' => $voxLog->character->login,
            ]);
        });

        static::updated(function ($voxLog) {
            info('Vox log updated', [
                'user' => auth()->user()->login,
                'character' => $voxLog->character->login,
            ]);
        });

        static::deleted(function ($voxLog) {
            info('Vox log deleted', [
                'user' => auth()->user()->login,
                'character' => $voxLog->character->login,
            ]);
        });
    }
}
