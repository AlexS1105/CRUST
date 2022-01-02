<?php

namespace App\Models;

use App\Enums\PerkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => PerkType::class
    ];

    public function variants()
    {
        return $this->hasMany(PerkVariant::class);
    }
}
