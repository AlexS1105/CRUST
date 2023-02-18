<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
