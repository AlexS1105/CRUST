<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tide extends Model
{
    use HasFactory;

    protected $fillable = [
        'tide',
        'level',
        'path',
    ];

    protected $casts = [
        'tide' => \App\Enums\Tide::class,
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
