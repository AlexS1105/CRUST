<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        static::created(function($voxLog) {
            info('Vox log created', [
                'user' => auth()->user()->login,
                'character' => $voxLog->character->login
            ]);
        });

        static::updated(function($voxLog) {
            info('Vox log updated', [
                'user' => auth()->user()->login,
                'character' => $voxLog->character->login
            ]);
        });

        static::deleted(function($voxLog) {
            info('Vox log deleted', [
                'user' => auth()->user()->login,
                'character' => $voxLog->character->login
            ]);
        });
    }
}
