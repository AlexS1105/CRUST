<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

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
