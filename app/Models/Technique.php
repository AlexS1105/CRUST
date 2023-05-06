<?php

namespace App\Models;

use App\Settings\CharsheetSettings;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
