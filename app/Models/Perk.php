<?php

namespace App\Models;

use App\Enums\PerkType;
use App\Traits\Searchable;
use BenSampo\Enum\Traits\QueriesFlaggedEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    use HasFactory, QueriesFlaggedEnums, Searchable;

    protected $fillable = [
        'name',
        'general_description',
        'type',
    ];

    protected $casts = [
        'type' => PerkType::class,
    ];

    public function variants()
    {
        return $this->hasMany(PerkVariant::class);
    }

    public function scopeType($query, $perkType)
    {
        if (isset($perkType)) {
            $perkType = PerkType::fromValue(intval($perkType));

            if ($perkType->value === PerkType::None) {
                $query->notHasFlag('type', PerkType::Combat)
                    ->notHasFlag('type', PerkType::Attack)
                    ->notHasFlag('type', PerkType::Defence);
            } else {
                $query->hasFlag('type', $perkType->value);
            }
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($perk) {
            info('Perk created', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perk->name,
            ]);
        });

        static::updated(function ($perk) {
            info('Perk updated', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perk->name,
            ]);
        });

        static::deleted(function ($perk) {
            info('Perk deleted', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perk->name,
            ]);
        });
    }
}
