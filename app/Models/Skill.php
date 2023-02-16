<?php

namespace App\Models;

use App\Enums\CharacterStat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
