<?php

namespace App\Models;

use App\Enums\FateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => FateType::class,
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
