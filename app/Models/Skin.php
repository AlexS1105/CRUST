<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
