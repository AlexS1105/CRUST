<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkVariant extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function perk()
    {
        return $this->belongsTo(Perk::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'characters_perks');
    }
}
