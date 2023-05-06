<?php

namespace App\Models;

use App\Enums\CharacterStat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'proficiency',
        'name',
        'description',
        'stat',
    ];

    protected $casts = [
        'stat' => CharacterStat::class,
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot('level')->using(CharacterSkill::class);
    }

    public function advantages()
    {
        return $this->hasMany(Advantage::class)->orderBy('level');
    }
}
