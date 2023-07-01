<?php

namespace App\Models;

use App\Settings\CharsheetSettings;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Technique
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @property-read int|null $characters_count
 * @method static \Database\Factories\TechniqueFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Technique forCharacter($character)
 * @method static \Illuminate\Database\Eloquent\Builder|Technique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technique query()
 * @method static \Illuminate\Database\Eloquent\Builder|Technique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technique whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technique whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technique whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Technique extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_technique');
    }

    public function cost(): Attribute
    {
        return Attribute::get(fn () => app(CharsheetSettings::class)->technique_cost);
    }

    public function scopeForCharacter($query, $character)
    {
        $techniqueIds = $character->techniques->pluck('id')->implode(',');

        if (empty($techniqueIds)) {
            return $query;
        }

        return $query->orderByRaw(DB::raw("FIELD(id, {$techniqueIds}) DESC"));
    }
}
