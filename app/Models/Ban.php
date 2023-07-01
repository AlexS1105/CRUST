<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ban
 *
 * @property int $id
 * @property int $user_id
 * @property string $reason
 * @property int|null $banned_by
 * @property \Illuminate\Support\Carbon|null $expires
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $by
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ban query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereBannedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereExpires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereUserId($value)
 * @mixin \Eloquent
 */
class Ban extends Model
{
    protected $guarded = [];

    protected $casts = [
        'expires' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function by()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function message(): Attribute
    {
        return Attribute::make(
            get: fn () => __('ban.message.'.(isset($this->expires) ? 'temporary' : 'permanent'), [
                'admin' => $this->by->login,
                'tag' => $this->by->discord_tag,
                'reason' => $this->reason,
                'time' => Carbon::parse($this->expires)->diffForHumans(),
            ]),
        );
    }

    protected static function booted()
    {
        parent::boot();

        static::created(function ($ban) {
            info('User banned', [
                'by' => auth()->user()->login,
                'user' => $ban->user->login,
            ]);
        });

        static::deleted(function ($ban) {
            info('User unbanned', [
                'by' => auth()->user()->login,
                'user' => $ban->user->login,
            ]);
        });
    }
}
