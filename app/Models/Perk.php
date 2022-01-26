<?php

namespace App\Models;

use App\Enums\PerkType;
use BenSampo\Enum\Traits\QueriesFlaggedEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    use HasFactory, QueriesFlaggedEnums;

    protected $guarded = [];

    protected $casts = [
        'type' => PerkType::class
    ];

    public function variants()
    {
        return $this->hasMany(PerkVariant::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($perk) {
            info('Perk created', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perk->name
            ]);
        });

        static::updated(function($perk) {
            info('Perk updated', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perk->name
            ]);
        });

        static::deleted(function($perk) {
            info('Perk deleted', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perk->name
            ]);
        });
    }
}
