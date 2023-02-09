<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Charsheet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $connection = 'mongodb2';

    protected $attributes = [
        'stats' => [
            'strength' => 1,
            'endurance' => 1,
            'perception' => 1,
            'agility' => 1,
            'determination' => 1,
            'erudition' => 1,
            'will' => 1,
            'potential' => 1,
        ],
        'crafts' => [
            'arc' => 0,
            'mys' => 0,
            'wiz' => 0,
            'mnf' => 0,
            'eng' => 0,
            'gun' => 0,
            'chm' => 0,
            'smt' => 0,
            'bld' => 0,
            'med' => 0,
        ],
    ];

    public function hasAnyCrafts()
    {
        return array_sum($this->crafts) > 0;
    }

    public function character()
    {
        return $this->hasOne(Character::class, 'character', 'login');
    }
}
