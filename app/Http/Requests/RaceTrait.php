<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaceTrait extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'characters_race_traits');
    }
}
