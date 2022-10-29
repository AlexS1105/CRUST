<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PerkVariant
 *
 * @property int $id
 * @property int $perk_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Character> $characters
 * @property-read int|null $characters_count
 * @property-read Perk $perk
 *
 * @method static \Database\Factories\PerkVariantFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant wherePerkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerkVariant whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PerkVariant extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['character'];

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

        static::created(function ($perkVariant) {
            info('Perk variant created', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perkVariant->perk->name,
            ]);
        });

        static::updated(function ($perkVariant) {
            info('Perk variant updated', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perkVariant->perk->name,
            ]);
        });

        static::deleted(function ($perkVariant) {
            info('Perk variant deleted', [
                'user' => auth()->user() !== null ? auth()->user()->login : 'CRUST',
                'perk' => $perkVariant->perk->name,
            ]);
        });
    }
}
