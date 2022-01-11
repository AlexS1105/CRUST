<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaceTrait extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'characters_race_traits');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($trait) {
            info('Trait created', [
                'user' => auth()->user()->login,
                'trait' => $trait->name
            ]);
        });

        static::updated(function($trait) {
            info('Trait updated', [
                'user' => auth()->user()->login,
                'trait' => $trait->name
            ]);
        });

        static::deleted(function($trait) {
            info('Trait deleted', [
                'user' => auth()->user()->login,
                'trait' => $trait->name
            ]);
        });
    }
}
