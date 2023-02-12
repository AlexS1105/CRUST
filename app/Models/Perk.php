<?php

namespace App\Models;

use App\Enums\PerkType;
use App\Traits\Searchable;
use BenSampo\Enum\Traits\QueriesFlaggedEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Perk
 *
 * @property int $id
 * @property string $name
 * @property mixed $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $general_description
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<PerkVariant> $variants
 * @property-read int|null $variants_count
 *
 * @method static \Database\Factories\PerkFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk hasAllFlags(string $column, array $flags)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk hasAnyFlags(string $column, array $flags)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk hasFlag(string $column, int $flag)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perk notHasFlag(string $column, int $flag)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk query()
 * @method static \Illuminate\Database\Eloquent\Builder|Perk search($search, $field = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Perk type($perkType)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk whereGeneralDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perk whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Perk extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'cost',
        'description',
    ];

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
