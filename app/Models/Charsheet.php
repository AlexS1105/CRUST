<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Charsheet extends Model
{
    use HasFactory;

    protected $connection = 'mongodb2';

    protected $attributes = [
        'special_stats' => [
            'points' => 36
        ],
        'approaches' => [
            'careful' => 0,
            'clever' => 0,
            'flashy' => 0,
            'forceful' => 0,
            'quick' => 0,
            'sneaky' => 0
        ],
        'crafts' => [
            'arc' => 0,
            'mys' => 0,
            'enc' => 0,
            'alc' => 0,
            'eng' => 0,
            'mnf' => 0,
            'inf' => 0,
            'chm' => 0,
            'smt' => 0,
        ],
    ];

    public function character()
    {
        return $this->hasOne(Character::class, 'character', 'login');
    }
}
