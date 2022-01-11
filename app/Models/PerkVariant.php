<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkVariant extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function perk()
    {
        return $this->belongsTo(Perk::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'characters_perks');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($perkVariant) {
            info('Perk variant created', [
                'user' => auth()->user()->login,
                'perk' => $perkVariant->perk->name
            ]);
        });

        static::updated(function($perkVariant) {
            info('Perk variant updated', [
                'user' => auth()->user()->login,
                'perk' => $perkVariant->perk->name
            ]);
        });

        static::deleted(function($perkVariant) {
            info('Perk variant deleted', [
                'user' => auth()->user()->login,
                'perk' => $perkVariant->perk->name
            ]);
        });
    }
}
