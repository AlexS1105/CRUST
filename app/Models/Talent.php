<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'name',
        'description',
        'cost',
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_talent');
    }

    public function scopeForCharacter($query, $character)
    {
        $talentIds = $character->talents->pluck('id')->implode(',');

        if (empty($talentIds)) {
            return $query;
        }

        return $query->orderByRaw(DB::raw("FIELD(id, {$talentIds}) DESC"));
    }
}
